<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Packing Slip - <?php echo e($order->reference); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: '#185FA5',
                    }
                }
            }
        }
    </script>
    <style>
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        @page {
            size: A4;
            margin: 10mm;
        }

        .barcode {
            font-family: 'Libre Barcode 39', monospace;
            font-size: 48px;
        }
    </style>
</head>

<body class="antialiased text-sm text-zinc-700 tracking-tight font-sans bg-white">
    <?php
        $logoPath = public_path('logo.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        }

        $delivery = $order->deliveryOrder;
        $shippingMethod = $delivery?->shippingMethod;
        $pickupStation = $delivery?->pickupStation;
    ?>

    
    
    
    <div class="flex justify-between items-start border-b-2 border-gray-300 pb-4 mb-6">
        <div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($logoBase64): ?>
                <img src="<?php echo e($logoBase64); ?>" alt="Sheffield Africa" class="h-10 w-auto">
            <?php else: ?>
                <div class="text-xl font-bold text-brand uppercase">SHEFFIELD</div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="text-right">
            <h1 class="text-2xl font-bold text-gray-900 uppercase">Packing Slip</h1>
            <div class="text-sm text-gray-500 mt-1">For warehouse use only</div>
        </div>
    </div>

    
    
    
    <div class="flex justify-between items-start mb-6">
        <div class="space-y-2">
            <div class="flex items-center gap-2">
                <span class="text-sm font-semibold text-gray-500 uppercase w-28">Order #:</span>
                <span class="text-lg font-bold text-gray-900"><?php echo e($order->reference); ?></span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-sm font-semibold text-gray-500 uppercase w-28">Order Date:</span>
                <span class="text-sm text-gray-900"><?php echo e($order->created_at->format('d M Y, H:i')); ?></span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-sm font-semibold text-gray-500 uppercase w-28">Status:</span>
                <span class="text-sm font-semibold text-gray-900"><?php echo e($order->status->label()); ?></span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-sm font-semibold text-gray-500 uppercase w-28">Total Items:</span>
                <span class="text-sm font-bold text-gray-900"><?php echo e($order->items->sum('quantity')); ?></span>
            </div>
        </div>

        
        <div class="flex flex-col items-center">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=<?php echo e(urlencode($order->reference)); ?>"
                alt="QR Code" class="w-24 h-24">
            <div class="text-xs text-gray-500 mt-1">Scan to view order</div>
        </div>
    </div>

    
    
    
    <div class="grid grid-cols-2 gap-6 mb-6">
        
        <div class="border border-gray-300 rounded">
            <div class="px-4 py-2 bg-gray-100 border-b border-gray-300">
                <div class="text-xs font-bold text-gray-700 uppercase">Ship To</div>
            </div>
            <div class="p-4">
                <div class="font-bold text-gray-900"><?php echo e($order->customerName()); ?></div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->customerPhone()): ?>
                    <div class="text-sm text-gray-600 mt-1"><?php echo e($order->customerPhone()); ?></div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->shipping_address): ?>
                    <div class="text-sm text-gray-600 mt-2 leading-relaxed">
                        <?php echo e($order->shipping_address['address'] ?? ''); ?><br>
                        <?php echo e(implode(
                            ', ',
                            array_filter([$order->shipping_address['area'] ?? null, $order->shipping_address['county'] ?? null]),
                        )); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        
        <div class="border border-gray-300 rounded">
            <div class="px-4 py-2 bg-gray-100 border-b border-gray-300">
                <div class="text-xs font-bold text-gray-700 uppercase">Shipping Method</div>
            </div>
            <div class="p-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($shippingMethod): ?>
                    <div class="font-bold text-gray-900"><?php echo e($shippingMethod->name); ?></div>
                <?php elseif($order->wasConvertedFromQuote()): ?>
                    <div class="font-bold text-gray-900">Quote Delivery</div>
                    <div class="text-sm text-gray-500 mt-1">Arranged separately</div>
                <?php else: ?>
                    <div class="text-gray-500">Not specified</div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pickupStation): ?>
                    <div class="mt-3 pt-3 border-t border-gray-200">
                        <div class="text-xs font-semibold text-gray-500 uppercase">Pickup Station</div>
                        <div class="text-sm font-semibold text-gray-900 mt-1"><?php echo e($pickupStation->name); ?></div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pickupStation->address): ?>
                            <div class="text-xs text-gray-600 mt-1"><?php echo e($pickupStation->address); ?></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->tracking_number): ?>
                    <div class="mt-3 pt-3 border-t border-gray-200">
                        <div class="text-xs font-semibold text-gray-500 uppercase">Tracking #</div>
                        <div class="text-sm font-mono font-semibold text-gray-900 mt-1"><?php echo e($order->tracking_number); ?>

                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>

    
    
    
    <div class="mb-6">
        <div class="text-xs font-bold text-gray-700 uppercase mb-2">Items to Pack</div>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th
                        class="border border-gray-300 py-2 px-3 text-xs font-bold text-gray-700 uppercase text-center w-12">
                        ✓</th>
                    <th class="border border-gray-300 py-2 px-3 text-xs font-bold text-gray-700 uppercase text-left">SKU
                    </th>
                    <th class="border border-gray-300 py-2 px-3 text-xs font-bold text-gray-700 uppercase text-left">
                        Product</th>
                    <th
                        class="border border-gray-300 py-2 px-3 text-xs font-bold text-gray-700 uppercase text-center w-20">
                        Qty</th>
                    <th
                        class="border border-gray-300 py-2 px-3 text-xs font-bold text-gray-700 uppercase text-center w-24">
                        Weight</th>
                    <th
                        class="border border-gray-300 py-2 px-3 text-xs font-bold text-gray-700 uppercase text-center w-20">
                        Picked</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php
                        $name = $item->product_snapshot['name'] ?? ($item->product?->name ?? '—');
                        $sku = $item->product_snapshot['sku'] ?? ($item->product?->sku ?? '—');
                        $weight = $item->product_snapshot['weight_kg'] ?? ($item->product?->weight_kg ?? null);
                        $variantAttrs = $item->product_snapshot['variant']['attributes'] ?? [];
                        $isBundle = ($item->product_snapshot['type'] ?? null) === 'bundle';
                        $bundleContents = $item->product_snapshot['bundle_contents'] ?? [];
                    ?>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3 text-center">
                            <div class="w-5 h-5 border-2 border-gray-400 rounded mx-auto"></div>
                        </td>
                        <td class="border border-gray-300 py-3 px-3">
                            <div class="text-xs font-mono text-gray-600"><?php echo e($sku); ?></div>
                        </td>
                        <td class="border border-gray-300 py-3 px-3">
                            <div class="font-semibold text-gray-900"><?php echo e($name); ?></div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($variantAttrs)): ?>
                                <div class="text-xs text-gray-500 mt-0.5">
                                    <?php echo e(collect($variantAttrs)->map(fn($v, $k) => "$k: $v")->join(' · ')); ?>

                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isBundle && !empty($bundleContents)): ?>
                                <div class="mt-2 pl-3 border-l-2 border-blue-300">
                                    <div class="text-xs font-semibold text-blue-600 mb-1">Bundle Contains:</div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $bundleContents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <div class="text-xs text-gray-600">
                                            • <?php echo e($child['name'] ?? 'Item'); ?>

                                            <span class="text-gray-400">(<?php echo e($child['sku'] ?? 'N/A'); ?>)</span>
                                            × <?php echo e($child['quantity'] ?? 1); ?>

                                        </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td class="border border-gray-300 py-3 px-3 text-center">
                            <div class="text-lg font-bold text-gray-900"><?php echo e($item->quantity); ?></div>
                        </td>
                        <td class="border border-gray-300 py-3 px-3 text-center">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($weight): ?>
                                <div class="text-sm text-gray-600"><?php echo e(number_format($weight * $item->quantity, 2)); ?> kg
                                </div>
                            <?php else: ?>
                                <div class="text-xs text-gray-400">—</div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td class="border border-gray-300 py-3 px-3 text-center">
                            <div class="w-5 h-5 border-2 border-gray-400 rounded mx-auto"></div>
                        </td>
                    </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </tbody>
        </table>
    </div>

    
    
    
    <div class="flex justify-between items-start mb-6">
        <div class="text-sm text-gray-600">
            <strong>Total SKUs:</strong> <?php echo e($order->items->count()); ?> |
            <strong>Total Units:</strong> <?php echo e($order->items->sum('quantity')); ?>

            <?php
                $totalWeight = $order->items->sum(function ($item) {
                    $weight = $item->product_snapshot['weight_kg'] ?? ($item->product?->weight_kg ?? 0);
                    return $weight * $item->quantity;
                });
            ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($totalWeight > 0): ?>
                | <strong>Est. Weight:</strong> <?php echo e(number_format($totalWeight, 2)); ?> kg
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    
    
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->customer_notes): ?>
        <div class="border border-amber-300 bg-amber-50 rounded p-4 mb-6">
            <div class="text-xs font-bold text-amber-700 uppercase mb-1">⚠️ Customer Notes</div>
            <div class="text-sm text-amber-800"><?php echo e($order->customer_notes); ?></div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    
    
    <div class="border-t-2 border-gray-300 pt-4 mt-6">
        <div class="grid grid-cols-2 gap-6">
            <div>
                <div class="text-xs font-bold text-gray-500 uppercase mb-2">Packed By</div>
                <div class="border-b border-gray-400 h-8"></div>
                <div class="text-xs text-gray-400 mt-1">Name & Signature</div>
            </div>
            <div>
                <div class="text-xs font-bold text-gray-500 uppercase mb-2">Date & Time</div>
                <div class="border-b border-gray-400 h-8"></div>
                <div class="text-xs text-gray-400 mt-1">DD/MM/YYYY HH:MM</div>
            </div>
        </div>

        <div class="mt-4">
            <div class="text-xs font-bold text-gray-500 uppercase mb-2">Quality Check</div>
            <div class="flex gap-6 text-sm">
                <label class="flex items-center gap-2">
                    <div class="w-4 h-4 border-2 border-gray-400 rounded"></div>
                    <span class="text-gray-600">All items present</span>
                </label>
                <label class="flex items-center gap-2">
                    <div class="w-4 h-4 border-2 border-gray-400 rounded"></div>
                    <span class="text-gray-600">Items undamaged</span>
                </label>
                <label class="flex items-center gap-2">
                    <div class="w-4 h-4 border-2 border-gray-400 rounded"></div>
                    <span class="text-gray-600">Properly packed</span>
                </label>
            </div>
        </div>
    </div>

    
    
    
    <div class="mt-8 pt-4 border-t border-gray-200 text-center text-xs text-gray-400">
        Generated on <?php echo e(now()->format('d M Y, H:i')); ?> | Internal document - Not for customer
    </div>
</body>

</html>
<?php /**PATH C:\Users\jonah.wakahiu\Desktop\ecommerce\sheffield_ecommerce\resources\views\pdf\packing-slip.blade.php ENDPATH**/ ?>