<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= base_url('assets/css/output.css') ?>">

    <style>
        .hover-grow {
            transition: all 0.3s;
            transform: scale(1);
        }

        .hover-grow:hover {
            transform: scale(1.02);
        }
    </style>
</head>

<body class="bg-white text-gray-600 leading-normal text-base tracking-normal">



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
            <a href="<?= base_url('admin/dashboard') ?>" class="text-sm  text-gray-900">Admin</a>
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

<section class="container mx-auto bg-gray-100 flex items-center bg-cover bg-center"
         style="max-width:1600px; height: 50vh;
         background-image:
         linear-gradient(to right, rgba(255,255,255,.9), rgba(255,255,255,.4)),
         url('<?= base_url('assets/images/landing.jpg') ?>');
         background-position: right bottom;">

    <div class="container mx-auto px-6">
        <div class="container mx-auto">
            <div class="flex flex-col w-full lg:w-1/2 md:ml-16 items-center md:items-start px-6 tracking-wide">
                <p class="text-black text-2xl my-4">GAMING STORE</p>
                <p class="text-gray-700 mb-6">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vel mi ut felis tempus commodo nec id erat. Suspendisse consectetur dapibus velit ut lacinia.
                </p>
                <a class="text-xl inline-block no-underline border-b border-gray-600 leading-relaxed hover:text-black hover:border-black" href="#products">view product</a>
            </div>
        </div>
    </div>
</section>

<section id="products" class="bg-white py-8">
    <div class="container mx-auto flex items-center flex-wrap pt-4 pb-12">

        <nav class="w-full z-30 top-0 px-6 py-1">
            <div class="w-full container mx-auto flex flex-wrap items-center justify-between px-2 py-3">
                <h1 class="uppercase tracking-wide font-bold text-gray-800 text-xl">
                    Store
                </h1>
            </div>
        </nav>

        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="w-full md:w-1/3 xl:w-1/4 p-6 flex flex-col">
                    <div class="bg-white">

                        <?php
                            $image = !empty($product['image'])
                                ? base_url($product['image'])
                                : 'https://dummyimage.com/400x400/e5e7eb/111827&text=No+Image';
                        ?>

                        <img class="hover-grow hover:shadow-lg w-full h-72 object-cover"
                             src="<?= esc($image) ?>"
                             alt="<?= esc($product['product_name']) ?>">

                        <div class="pt-3 flex items-center justify-between">
                            <p class="font-medium text-gray-800">
                                <?= esc($product['product_name']) ?>
                            </p>

                            <span class="text-sm text-gray-500">
                                Stock: <?= esc($product['qty_in_stock']) ?>
                            </span>
                        </div>

                        <p class="pt-1 text-gray-500 text-sm line-clamp-2">
                            <?= esc($product['description'] ?? 'No description available') ?>
                        </p>

                        <p class="pt-2 text-gray-900 font-semibold">
                            Rp <?= number_format($product['price'], 0, ',', '.') ?>
                        </p>

                        <form action="<?= base_url('cart/add/' . $product['product_id']) ?>" method="post">
                            <?= csrf_field() ?>

                            <button type="submit"
                                class="w-full bg-gray-900 text-white py-2 px-4 rounded-lg
                                    hover:bg-gray-700 hover:scale-105 hover:shadow-lg
                                    transition duration-300 cursor-pointer">

                                Add to Cart

                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="w-full px-6 py-12 text-center">
                <p class="text-gray-500">No products available.</p>
            </div>
        <?php endif; ?>

    </div>
</section>

<section id="about" class="bg-white py-8 border-t">
    <div class="container py-8 px-6 mx-auto">
        <h2 class="uppercase tracking-wide font-bold text-gray-800 text-xl mb-8">
            About
        </h2>

        <p class="mb-8 text-gray-600">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vel mi ut felis tempus commodo nec id erat. Suspendisse consectetur dapibus velit ut lacinia. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vel mi ut felis tempus commodo nec id erat. Suspendisse consectetur dapibus velit ut lacinia.
        </p>
    </div>
</section>

<footer class="container mx-auto bg-white py-8 border-t border-gray-300">
    <div class="px-6">
        <p class="text-gray-600">
            &copy; <?= date('Y') ?> lorem ipsum dolor sit amet, consectetur adipiscing elit. All rights reserved.
        </p>
    </div>
</footer>

</body>
</html>