<?php

namespace App\Livewire\Concerns;

use App\Enums\ProductType;
use App\Enums\StockStatus;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Support\StorefrontSession;
use App\Support\TaxCalculator;
use Flux\Flux;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;

/**
 * Mix into any Livewire page that renders <x-storefront.product-card> so
 * the card's "Add to cart" and wishlist-heart buttons can dispatch
 * wire:click actions on the parent.
 *
 * Adding a product that has accessory links opens a "Complete your purchase"
 * prompt so the customer can add the matching accessories (e.g. an oven's
 * trays) in the same step instead of shopping for them separately.
 */
trait InteractsWithStorefront
{
    // ==================================================
    // ACCESSORY PROMPT ("Complete your purchase")
    // ==================================================

    public bool $showAccessoryModal = false;

    public string $accessoryParentName = '';

    /**
     * Display rows for the prompt, captured when it opens.
     *
     * @var array<int, array{slug: string, name: string, image: ?string, price_cents: ?int, is_required: bool, in_stock: bool}>
     */
    public array $accessoryModalItems = [];

    /**
     * Customer selections keyed by accessory slug.
     *
     * @var array<string, array{checked: bool, qty: int}>
     */
    public array $accessorySelections = [];

    public function addToCart(string $slug, int $qty = 1, ?int $variantId = null): void
    {
        StorefrontSession::addToCart($slug, $qty, $variantId);
        $key = StorefrontSession::lineKey($slug, $variantId);
        $newQty = StorefrontSession::cartQuantity($key);

        $this->dispatch('cart-updated');
        $this->dispatch('cart-qty-changed', slug: $slug, qty: $newQty);

        // A specific variant is the line the customer chose; only prompt for
        // accessories when adding the base product.
        if ($variantId === null && $this->openAccessoryPrompt($slug)) {
            // Keep rendering so the modal appears; the modal is the feedback.
            return;
        }

        if ($this->skipRenderAfterAddToCart()) {
            $this->skipRender();
        }

        Flux::toast(heading: 'Added to cart', text: 'Item has been added to your cart.', variant: 'success');
    }

    /**
     * Card listings skip the re-render so morphing can't tear down JS-initialised
     * DOM (the hero Swiper, carousels); the card reflects its new state client-side
     * instead. Pages whose own markup depends on cart contents - the product page
     * swaps its Add to cart button for a counter - must override this and render.
     */
    protected function skipRenderAfterAddToCart(): bool
    {
        return true;
    }

    /**
     * Capture the just-added product's accessories and open the prompt.
     * Returns false (no prompt) when the product has no visible accessories.
     */
    protected function openAccessoryPrompt(string $parentSlug): bool
    {
        // Reuse already-loaded product when available (e.g. on the product page).
        $parent = (isset($this->product) && $this->product instanceof Product && $this->product->slug === $parentSlug)
            ? $this->product
            : Product::query()->where('slug', $parentSlug)->where('visibility', 'visible')->first();

        if (! $parent) {
            return false;
        }

        $accessories = $parent->accessories()
            ->visibleInCatalog()
            ->published()
            ->with('media')
            ->get();

        if ($accessories->isEmpty()) {
            return false;
        }

        $tax = app(TaxCalculator::class);
        $items = [];
        $selections = [];

        foreach ($accessories as $accessory) {
            $price = $accessory->sale_price ?? $accessory->price;
            $qty = max(1, (int) $accessory->pivot->default_quantity);

            $items[] = [
                'slug' => $accessory->slug,
                'name' => $accessory->name,
                'image' => $accessory->cover_url,
                'price_cents' => $price ? $tax->displayPriceCents($accessory, (int) $price) : null,
                'is_required' => (bool) $accessory->pivot->is_required,
                'in_stock' => $accessory->stock_status === StockStatus::IN_STOCK,
            ];

            // Required and recommended accessories are both pre-checked; the
            // customer can adjust the quantity or uncheck before confirming.
            $selections[$accessory->slug] = ['checked' => true, 'qty' => $qty];
        }

        $this->accessoryParentName = $parent->name;
        $this->accessoryModalItems = $items;
        $this->accessorySelections = $selections;
        $this->showAccessoryModal = true;

        return true;
    }

    public function incAccessoryQty(string $slug): void
    {
        if (! isset($this->accessorySelections[$slug])) {
            return;
        }

        $this->accessorySelections[$slug]['qty'] = min(99, (int) ($this->accessorySelections[$slug]['qty'] ?? 1) + 1);
    }

    public function decAccessoryQty(string $slug): void
    {
        if (! isset($this->accessorySelections[$slug])) {
            return;
        }

        $this->accessorySelections[$slug]['qty'] = max(1, (int) ($this->accessorySelections[$slug]['qty'] ?? 1) - 1);
    }

    /** Add the checked accessories to the cart as their own line items. */
    public function addSelectedAccessories(): void
    {
        // Only slugs captured when the prompt opened are honoured (the public
        // selections array is client-editable).
        $allowed = collect($this->accessoryModalItems)->keyBy('slug');
        $added = 0;

        foreach ($this->accessorySelections as $accessorySlug => $selection) {
            if (! $allowed->has($accessorySlug) || empty($selection['checked'])) {
                continue;
            }

            $qty = max(1, (int) ($selection['qty'] ?? 1));
            StorefrontSession::addToCart($accessorySlug, $qty);
            $added += $qty;
        }

        $this->closeAccessoryModal();
        $this->dispatch('cart-updated');

        Flux::toast(
            heading: $added > 0 ? 'Added to cart' : 'Nothing added',
            text: $added > 0 ? 'Your accessories have been added to the cart.' : 'No accessories were selected.',
            variant: $added > 0 ? 'success' : 'warning',
        );
    }

    public function closeAccessoryModal(): void
    {
        $this->showAccessoryModal = false;
        $this->accessoryParentName = '';
        $this->accessoryModalItems = [];
        $this->accessorySelections = [];
    }

    // ==================================================
    // VARIATION PICKER
    // ==================================================

    public bool $showVariationModal = false;

    /** Slug of the variable product whose variants the modal is showing. */
    public string $variationProductSlug = '';

    /** Open the variation picker for a variable product. */
    public function openVariationModal(string $slug): void
    {
        $product = $this->resolveVariationProduct($slug);

        if (! $product) {
            return;
        }

        $this->variationProductSlug = $slug;
        $this->showVariationModal = true;
    }

    public function closeVariationModal(): void
    {
        $this->showVariationModal = false;
        $this->variationProductSlug = '';
    }

    /**
     * The variable product the modal is showing, with everything its rows need.
     * Resolved per request rather than held in state, so a tampered slug can only
     * ever name a published, catalog-visible product.
     */
    protected function resolveVariationProduct(?string $slug = null): ?Product
    {
        $slug ??= $this->variationProductSlug;

        // On the product page the modal is always about the page's own product, so
        // no slug is set when opening it from there.
        if ($slug === '' || $slug === null) {
            $slug = (isset($this->product) && $this->product instanceof Product)
                ? $this->product->slug
                : null;
        }

        if ($slug === null) {
            return null;
        }

        // The product page already holds the product; reuse it rather than re-query.
        if (isset($this->product) && $this->product instanceof Product && $this->product->slug === $slug) {
            $product = $this->product;
        } else {
            $product = Product::query()
                ->visibleInCatalog()
                ->published()
                ->where('slug', $slug)
                ->first();
        }

        if (! $product || $product->type !== ProductType::VARIABLE) {
            return null;
        }

        if (! $product->relationLoaded('variants')) {
            $product->load([
                'variants' => fn ($q) => $q->where('is_active', true)->orderBy('sort_order'),
                'variants.attributeValues.attribute',
                'variants.media',
            ]);
        }

        return $product;
    }

    /**
     * Modal rows - one per variant, with the label, reference, price, stock and the
     * quantity currently in the cart.
     *
     * @return Collection<int, array{id: int, reference: string, label: string, price_cents: int|null, in_stock: bool, backorder: bool, stock_quantity: int|null, image: string|null, qty: int}>
     */
    #[Computed]
    public function variationRows(): Collection
    {
        $product = $this->resolveVariationProduct();

        if (! $product) {
            return collect();
        }

        $tax = app(TaxCalculator::class);

        return $product->variants->map(function (ProductVariant $variant) use ($product, $tax) {
            // Mirrors StorefrontSession's unit-price rule so the figure shown here
            // is the figure charged.
            $price = $variant->compare_at_price ?? $variant->price;

            return [
                'id' => $variant->id,
                // Customers recognise the manufacturer's model number, not our
                // internal SKU; fall back through the parent's before the SKU.
                'reference' => $variant->model_number ?: ($product->model_number ?: $variant->sku),
                'label' => $variant->attributeValues->map(fn ($value) => $value->label ?: $value->value)->join(' / '),
                'price_cents' => $price ? $tax->displayPriceCents($product, (int) $price) : null,
                'in_stock' => $variant->stock_status === StockStatus::IN_STOCK,
                'backorder' => $variant->stock_status === StockStatus::BACKORDER,
                // null means stock isn't tracked for this variant, which is not
                // the same as zero - show nothing rather than "0 in stock".
                'stock_quantity' => $variant->stock_quantity,
                'image' => $variant->getFirstMediaUrl('image', 'thumb') ?: $product->cover_url,
                // The stepper reads straight off the cart, so it shows 0 for a
                // variant that isn't in it and reflects edits made elsewhere.
                'qty' => StorefrontSession::cartQuantity(StorefrontSession::lineKey($product->slug, $variant->id)),
            ];
        })->values();
    }

    /**
     * Put one more of this variant in the cart. The stepper edits the cart live,
     * so there is nothing to confirm afterwards.
     *
     * addToCart() is deliberately not reused here: it calls skipRender(), which
     * would leave the counter showing its old value.
     */
    public function incVariationQty(int $variantId): void
    {
        $product = $this->resolveVariationProduct();
        $variant = $this->orderableVariant($product, $variantId);

        if (! $variant) {
            return;
        }

        StorefrontSession::addToCart($product->slug, 1, $variantId);
        unset($this->variationRows);
        $this->dispatch('cart-updated');

        $label = $variant->attributeValues->map(fn ($value) => $value->label ?: $value->value)->join(' / ');

        Flux::toast(
            heading: 'Added to cart',
            text: trim($product->name.' '.$label).' has been added to your cart.',
            variant: 'success',
        );
    }

    /** Take one of this variant out of the cart, dropping the line at zero. */
    public function decVariationQty(int $variantId): void
    {
        $product = $this->resolveVariationProduct();
        $variant = $this->orderableVariant($product, $variantId);

        if (! $variant) {
            return;
        }

        $key = StorefrontSession::lineKey($product->slug, $variantId);
        $qty = StorefrontSession::cartQuantity($key);

        // Nothing to take out - the stepper is already disabled at zero, so this
        // can only be a stale click. Staying silent avoids a misleading toast.
        if ($qty === 0) {
            return;
        }

        if ($qty <= 1) {
            StorefrontSession::removeFromCart($key);
        } else {
            StorefrontSession::setCartQty($key, $qty - 1);
        }

        unset($this->variationRows);
        $this->dispatch('cart-updated');

        $name = trim($product->name.' '.$variant->attributeValues->map(fn ($value) => $value->label ?: $value->value)->join(' / '));

        Flux::toast(
            heading: $qty <= 1 ? 'Item removed' : 'Cart updated',
            text: $qty <= 1
                ? $name.' has been removed from your cart.'
                : $name.' reduced to '.($qty - 1).' in your cart.',
            variant: 'warning',
        );
    }

    /**
     * The variant a shopper may actually order - the guard for variant ids arriving
     * from the client, which could name any row in the table.
     */
    private function orderableVariant(?Product $product, int $variantId): ?ProductVariant
    {
        $variant = $product?->variants->firstWhere('id', $variantId);

        return $variant && $variant->stock_status === StockStatus::IN_STOCK ? $variant : null;
    }

    public function decrementCart(string $slug): void
    {
        $current = StorefrontSession::cartQuantity($slug);

        if ($current <= 1) {
            StorefrontSession::removeFromCart($slug);
        } else {
            StorefrontSession::setCartQty($slug, $current - 1);
        }

        $this->skipRender();
        $this->dispatch('cart-updated');
        $this->dispatch('cart-qty-changed', slug: $slug, qty: StorefrontSession::cartQuantity($slug));
    }

    public function toggleWishlist(string $slug): void
    {
        $added = StorefrontSession::toggleWishlist($slug);

        // The button reflects its new state client-side via the dispatched
        // event; skip the re-render so morphing can't tear down JS-initialised
        // DOM elsewhere on the page (e.g. the hero Swiper slider).
        $this->skipRender();
        $this->dispatch('wishlist-updated', slug: $slug, wished: $added);
        Flux::toast(
            heading: $added ? 'Saved to wishlist' : 'Removed from wishlist',
            text: $added ? 'You can view your saved items on the wishlist page.' : 'Item has been removed from your wishlist.',
            variant: $added ? 'success' : 'warning',
        );
    }

    public function toggleCompare(string $slug): void
    {
        $added = StorefrontSession::toggleCompare($slug);

        $this->skipRender();
        $this->dispatch('compare-updated', slug: $slug, compared: $added);
        Flux::toast(
            heading: $added ? 'Added to compare' : 'Removed from compare',
            text: $added ? 'Head to the compare page to view products side by side.' : 'Item has been removed from your compare list.',
            variant: $added ? 'success' : 'warning',
        );
    }
}
