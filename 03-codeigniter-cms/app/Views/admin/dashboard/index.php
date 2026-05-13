<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= base_url('assets/css/output.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-white text-gray-700">

<nav class="w-full z-30 top-0 border-b border-gray-200 bg-white">
    <div class="container mx-auto flex items-center justify-between px-6 py-4">
        <div class="flex items-center gap-10">
            <a href="<?= base_url('/') ?>" class="font-bold text-gray-800 text-xl">
                GAMING STORE
            </a>

            <div class="hidden md:flex items-center gap-8 text-sm text-gray-600">
                <a href="<?= base_url('#products') ?>" class="hover:text-gray-900">Shop</a>
                <a href="<?= base_url('#about') ?>" class="hover:text-gray-900">About</a>
            </div>
        </div>

        <div class="flex items-center gap-6 text-gray-600">
            <a href="<?= base_url('history') ?>" class="text-sm hover:text-gray-900">History</a>
            <a href="<?= base_url('cart') ?>" class="text-sm hover:text-gray-900">Cart</a>
            <a href="<?= base_url('admin/dashboard') ?>" class="text-sm font-semibold text-gray-900">Admin</a>
        </div>
    </div>
</nav>

<main class="bg-gray-100 min-h-screen">

    <div class="flex">

        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 min-h-screen hidden lg:block">

            <div class="p-6">

                <p class="text-sm text-gray-400 font-medium mb-4">
                    Main
                </p>

                <div class="space-y-2">

                    <a href="<?= base_url('admin/dashboard') ?>"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl bg-red-50 text-red-500 font-medium">

                        <i class="fa-solid fa-house text-sm"></i>

                        <span>
                            Dashboard
                        </span>

                    </a>

                    <a href="<?= base_url('admin/products') ?>"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-100 transition">

                        <i class="fa-solid fa-cube text-sm"></i>

                        <span>
                            Inventory
                        </span>

                    </a>

                    <a href="<?= base_url('admin/products/create') ?>"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-100 transition">

                        <i class="fa-solid fa-plus text-sm"></i>

                        <span>
                            Add Product
                        </span>

                    </a>



                </div>

            </div>

        </aside>

        <!-- Content -->
        <div class="flex-1 py-8">
            <div class="container mx-auto px-6">

                <h1 class="text-3xl font-bold text-gray-900">
                    Dashboard
                </h1>

                <p class="text-gray-500 mt-1 mb-8">
                    lorem ipsum dolor sit amet, consectetur adipiscing elit.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                    <div class="bg-white border border-gray-200 rounded-xl p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">
                                    Rp<?= number_format($totalProfit, 0, ',', '.') ?>
                                </h2>
                                <p class="mt-2 text-gray-700">Total Profit</p>
                            </div>

                            <i class="fa-regular fa-money-bill-1 text-3xl text-yellow-500"></i>
                        </div>

                        <div class="border-t mt-8"></div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-xl p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">
                                    <?= esc($totalProductSale) ?>
                                </h2>
                                <p class="mt-2 text-gray-700">Total Product Sale</p>
                            </div>

                            <i class="fa-regular fa-credit-card text-3xl text-pink-500"></i>
                        </div>

                        <div class="border-t mt-8"></div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-xl p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">
                                    <?= esc($totalStock) ?>
                                </h2>
                                <p class="mt-2 text-gray-700">Total Stock</p>
                            </div>

                            <i class="fa-regular fa-copy text-3xl text-red-500"></i>
                        </div>

                        <div class="border-t mt-8"></div>
                    </div>

                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900">
                                Top Selling Products
                            </h2>
                        </div>

                        <div>

                            <?php foreach($topSelling as $item): ?>

                                <div class="flex items-center gap-4 px-6 py-4 border-b border-gray-200 last:border-b border-gray-200-0">

                                    <img
                                        src="<?= base_url($item['product']['image']) ?>"
                                        class="w-14 h-14 rounded-lg object-cover border border-gray-200 bg-gray-100">

                                    <div class="flex-1">

                                        <h3 class="font-medium text-gray-900">
                                            <?= esc($item['product']['product_name']) ?>
                                        </h3>

                                        <p class="text-sm text-gray-500">
                                            Rp<?= number_format($item['product']['price'], 0, ',', '.') ?>
                                            •
                                            <?= esc($item['total_qty']) ?> Units
                                        </p>

                                    </div>

                                    <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-bold">
                                        <?= esc($item['total_qty']) ?>
                                    </span>

                                </div>

                            <?php endforeach; ?>

                        </div>

                    </div>
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                            <h2 class="text-xl font-semibold text-gray-900">
                                Low Stock Products
                            </h2>

                            <a href="<?= base_url('admin/products') ?>" class="text-sm text-red-500 hover:underline">
                                View All
                            </a>
                        </div>

                        <div>
                            <?php foreach($lowStockProducts as $product): ?>
                                <div class="flex items-center gap-4 px-6 py-4 border-b border-gray-200 last:border-b border-gray-200-0">

                                    <img src="<?= base_url($product['image']) ?>"
                                        class="w-14 h-14 rounded-lg object-cover border border-gray-200 bg-gray-100">

                                    <div class="flex-1">
                                        <h3 class="font-medium text-gray-900">
                                            <?= esc($product['product_name']) ?>
                                        </h3>

                                        <p class="text-sm text-gray-500">
                                            ID: #<?= esc($product['product_id']) ?>
                                        </p>
                                    </div>

                                    <div class="text-right">
                                        <p class="font-bold text-red-500">
                                            <?= esc($product['qty_in_stock']) ?>
                                        </p>

                                        <p class="text-sm text-gray-500">
                                            In Stock
                                        </p>
                                    </div>

                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900">
                                Recent Sales
                            </h2>
                        </div>

                        <div>
                            <?php foreach($recentSales as $sale): ?>
                                <?php
                                    $status = strtolower($sale['status']);

                                    $badgeClass = match ($status) {
                                        'paid' => 'bg-green-100 text-green-700',
                                        'pending' => 'bg-yellow-100 text-yellow-700',
                                        default => 'bg-gray-100 text-gray-700'
                                    };
                                ?>

                                <div class="flex items-center gap-4 px-6 py-4 border-b border-gray-200 last:border-b-0">

                                    <img src="<?= base_url($sale['product']['image'] ?? '') ?>"
                                        class="w-14 h-14 rounded-lg object-cover border border-gray-200 bg-gray-100">

                                    <div class="flex-1">
                                        <h3 class="font-medium text-gray-900">
                                            <?= esc($sale['product']['product_name'] ?? 'Produk') ?>
                                        </h3>

                                        <p class="text-sm text-gray-500">
                                            Qty <?= esc($sale['qty']) ?> • Rp<?= number_format($sale['total_price'], 0, ',', '.') ?>
                                        </p>
                                    </div>

                                    <span class="<?= $badgeClass ?> px-3 py-1 rounded-full text-xs font-bold capitalize">
                                        <?= esc($sale['status']) ?>
                                    </span>

                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</main>

</body>
</html>