<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
    Storage::fake('media');
});

it('saves an uploaded gallery video as a video_file media item', function () {
    // Gallery/media saving lives in saveRelationships(), which only runs when editing
    // an existing product - a brand-new save just creates the row and redirects into
    // edit mode, so the product must already exist for this to persist.
    $product = Product::factory()->create();

    Livewire::test('pages::admin.products.form', ['product' => $product])
        ->set('pendingGalleryVideo', UploadedFile::fake()->create('demo.mp4', 500, 'video/mp4'))
        ->call('save');

    $video = $product->fresh()->getMedia('images')->first();

    expect($video)->not->toBeNull()
        ->and($video->getCustomProperty('media_type'))->toBe('video_file')
        // Fake upload bytes have no real video signature, so finfo can't identify them -
        // the meaningful assertion is that it was never mistaken for an image.
        ->and($video->mime_type)->not->toStartWith('image/');
});

it('adds a resolved video URL to the pending list', function () {
    Http::fake(['img.youtube.com/*' => Http::response('fake-jpeg-bytes')]);

    Livewire::test('pages::admin.products.form')
        ->set('videoUrlInput', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ')
        ->call('addGalleryVideoUrl')
        ->assertHasNoErrors()
        ->assertSet('videoUrlInput', '')
        ->assertCount('pendingGalleryVideoUrls', 1);
});

it('rejects an invalid video URL', function () {
    Livewire::test('pages::admin.products.form')
        ->set('videoUrlInput', 'not-a-url')
        ->call('addGalleryVideoUrl')
        ->assertHasErrors('videoUrlInput');
});

it('rejects a recognized-provider URL when the thumbnail fetch fails', function () {
    Http::fake(['img.youtube.com/*' => Http::response(null, 404)]);

    Livewire::test('pages::admin.products.form')
        ->set('videoUrlInput', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ')
        ->call('addGalleryVideoUrl')
        ->assertHasErrors('videoUrlInput')
        ->assertCount('pendingGalleryVideoUrls', 0);
});

it('saves an added video URL as a video_embed media item backed by its thumbnail', function () {
    // Real JPEG bytes, not junk text: the downloaded thumbnail becomes the Media row's
    // actual backing file, and Spatie/finfo need genuine image data to detect it as one.
    // Held in a variable: the fake upload's temp file is removed once it is collected.
    $fakeThumb = UploadedFile::fake()->image('thumb.jpg', 10, 10);
    $realJpegBytes = file_get_contents($fakeThumb->getRealPath());

    Http::fake([
        'vimeo.com/api/oembed.json*' => Http::response(['thumbnail_url' => 'https://i.vimeocdn.com/video/123.jpg']),
        'i.vimeocdn.com/*' => Http::response($realJpegBytes),
    ]);

    $product = Product::factory()->create();

    Livewire::test('pages::admin.products.form', ['product' => $product])
        ->set('videoUrlInput', 'https://vimeo.com/76979871')
        ->call('addGalleryVideoUrl')
        ->assertHasNoErrors()
        ->call('save');

    $video = $product->fresh()->getMedia('images')->first();

    expect($video)->not->toBeNull()
        ->and($video->getCustomProperty('media_type'))->toBe('video_embed')
        ->and($video->getCustomProperty('video_provider'))->toBe('vimeo')
        ->and($video->getCustomProperty('embed_url'))->toBe('https://player.vimeo.com/video/76979871')
        ->and($video->mime_type)->toStartWith('image/');
});

it('removes a video gallery item like any other media row', function () {
    $product = Product::factory()->create();

    // Held in a variable: the fake upload's temp file is removed once it is collected.
    $upload = UploadedFile::fake()->create('demo.mp4', 500, 'video/mp4');
    $product->addMedia($upload->getRealPath())
        ->usingFileName('demo.mp4')
        ->withCustomProperties(['is_cover' => false, 'media_type' => 'video_file'])
        ->toMediaCollection('images');

    Livewire::test('pages::admin.products.form', ['product' => $product])
        ->call('removeGalleryImage', 0);

    expect($product->fresh()->getMedia('images'))->toHaveCount(0);
});

it('reorders saved gallery images and persists the new order with the cover first', function () {
    $product = Product::factory()->create();

    // Held in variables: each fake upload's temp file is removed once it is collected.
    $coverFile = UploadedFile::fake()->image('cover.jpg');
    $aFile = UploadedFile::fake()->image('a.jpg');
    $bFile = UploadedFile::fake()->image('b.jpg');
    $cFile = UploadedFile::fake()->image('c.jpg');

    $cover = $product->addMedia($coverFile->getRealPath())->usingFileName('cover.jpg')
        ->withCustomProperties(['is_cover' => true])->toMediaCollection('images');
    $a = $product->addMedia($aFile->getRealPath())->usingFileName('a.jpg')
        ->withCustomProperties(['is_cover' => false])->toMediaCollection('images');
    $b = $product->addMedia($bFile->getRealPath())->usingFileName('b.jpg')
        ->withCustomProperties(['is_cover' => false])->toMediaCollection('images');
    $c = $product->addMedia($cFile->getRealPath())->usingFileName('c.jpg')
        ->withCustomProperties(['is_cover' => false])->toMediaCollection('images');

    $component = Livewire::test('pages::admin.products.form', ['product' => $product]);

    // mount() loads the gallery (cover excluded) in insertion order.
    expect(collect($component->get('galleryImages'))->pluck('id')->all())->toBe([$a->id, $b->id, $c->id]);

    // Drag the first gallery item to the end.
    $component->call('handleGallerySort', $a->id, 2);

    expect(collect($component->get('galleryImages'))->pluck('id')->all())->toBe([$b->id, $c->id, $a->id]);

    // The new order is persisted to order_column, with the cover still leading the collection.
    expect($product->fresh()->getMedia('images')->pluck('id')->all())
        ->toBe([$cover->id, $b->id, $c->id, $a->id]);
});
