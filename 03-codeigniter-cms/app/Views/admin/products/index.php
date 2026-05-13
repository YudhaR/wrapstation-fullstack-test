<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet"
          href="<?= base_url('assets/css/output.css') ?>">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-white text-gray-700">

<nav class="w-full z-30 top-0 border-b border-gray-200 bg-white">
    <div class="container mx-auto flex items-center justify-between px-6 py-4">

        <div class="flex items-center gap-10">

            <a href="<?= base_url('/') ?>"
               class="font-bold text-gray-800 text-xl">
                GAMING STORE
            </a>

            <div class="hidden md:flex items-center gap-8 text-sm text-gray-600">
                <a href="<?= base_url('#products') ?>" class="hover:text-gray-900">
                    Shop
                </a>

                <a href="<?= base_url('#about') ?>" class="hover:text-gray-900">
                    About
                </a>
            </div>

        </div>

        <div class="flex items-center gap-6 text-gray-600">

            <a href="<?= base_url('history') ?>"
               class="text-sm hover:text-gray-900">
                History
            </a>

            <a href="<?= base_url('cart') ?>"
               class="text-sm hover:text-gray-900">
                Cart
            </a>

            <a href="<?= base_url('admin/dashboard') ?>"
               class="text-sm font-semibold text-gray-900">
                Admin
            </a>

        </div>

    </div>
</nav>

<?php if(session()->getFlashdata('success')): ?>

    <div 
        id="successToast"
        class="fixed top-5 right-5 z-50 bg-green-600 text-white px-6 py-4 rounded-xl shadow-xl transition-all duration-500">

        <?= session()->getFlashdata('success') ?>

    </div>

    <script>
        setTimeout(() => {

            const toast = document.getElementById('successToast');

            toast.classList.add(
                'opacity-0',
                'translate-x-10'
            );

            setTimeout(() => {
                toast.remove();
            }, 500);

        }, 5000);
    </script>

<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>

    <div 
        id="errorToast"
        class="fixed top-5 right-5 z-50 bg-red-600 text-white px-6 py-4 rounded-xl shadow-xl transition-all duration-500">

        <?= session()->getFlashdata('error') ?>

    </div>

    <script>
        setTimeout(() => {

            const toast = document.getElementById('errorToast');

            toast.classList.add(
                'opacity-0',
                'translate-x-10'
            );

            setTimeout(() => {
                toast.remove();
            }, 500);

        }, 5000);
    </script>

<?php endif; ?>

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
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-100 transition">

                        <i class="fa-solid fa-house text-sm"></i>

                        <span>
                            Dashboard
                        </span>

                    </a>

                    <a href="<?= base_url('admin/products') ?>"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl bg-red-50 text-red-500 font-medium">

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

                <div class="flex items-center justify-between mb-8">

                    <div>

                        <h1 class="text-3xl font-bold text-gray-900">
                            Inventory
                        </h1>

                        <p class="text-gray-500 mt-1">
                            lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </p>

                    </div>

                    <a href="<?= base_url('admin/products/create') ?>"
                       class="bg-gray-900 text-white px-5 py-3 rounded-xl font-medium hover:bg-gray-700 transition">

                        Add Product

                    </a>

                </div>

                <?php if (!empty($products)): ?>

                    <div class="flex flex-wrap -mx-3">

                        <?php foreach ($products as $product): ?>

                            <div class="w-full md:w-1/2 xl:w-1/4 p-3 flex flex-col">

                                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition">

                                    <?php
                                        $image = !empty($product['image'])
                                            ? base_url($product['image'])
                                            : 'https://dummyimage.com/400x400/e5e7eb/111827&text=No+Image';
                                    ?>

                                    <img class="w-full h-72 object-cover"
                                         src="<?= esc($image) ?>"
                                         alt="<?= esc($product['product_name']) ?>">

                                    <div class="p-5">

                                        <div class="flex items-center justify-between">

                                            <p class="font-semibold text-gray-800 line-clamp-1">
                                                <?= esc($product['product_name']) ?>
                                            </p>

                                            <span class="text-sm text-gray-500">
                                                Stock: <?= esc($product['qty_in_stock']) ?>
                                            </span>

                                        </div>

                                        <p class="pt-3 text-gray-500 text-sm line-clamp-2 min-h-[40px]">
                                            <?= esc($product['description'] ?? 'No description available') ?>
                                        </p>

                                        <p class="pt-4 text-gray-900 font-bold text-lg">
                                            Rp <?= number_format($product['price'], 0, ',', '.') ?>
                                        </p>

                                        <div class="grid grid-cols-2 gap-3 mt-5">

                                            <a href="<?= base_url('admin/products/edit/' . $product['product_id']) ?>"
                                               class="w-full bg-gray-900 text-white py-3 rounded-xl
                                                      hover:bg-gray-700 transition text-center font-medium">

                                                Edit

                                            </a>

                                            <a href="<?= base_url('admin/products/delete/' . $product['product_id']) ?>"
                                               onclick="return confirm('Delete this product?')"
                                               class="w-full border border-red-500 text-red-500 py-3 rounded-xl
                                                      hover:bg-red-500 hover:text-white transition text-center font-medium">

                                                Delete

                                            </a>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    </div>

                <?php else: ?>

                    <div class="bg-white border border-gray-200 rounded-2xl p-10 text-center">

                        <i class="fa-solid fa-box-open text-5xl text-gray-300"></i>

                        <h2 class="text-xl font-bold text-gray-900 mt-5">
                            No Products Found
                        </h2>

                        <p class="text-gray-500 mt-2">
                            lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </p>

                        <a href="<?= base_url('admin/products/create') ?>"
                           class="inline-block mt-6 bg-gray-900 text-white px-6 py-3 rounded-xl font-bold hover:bg-gray-700 transition">

                            Add Product

                        </a>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

</main>

</body>
</html>