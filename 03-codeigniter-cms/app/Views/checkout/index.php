<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= base_url('assets/css/output.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
            <a href="<?= base_url('cart') ?>" class="text-sm font-semibold hover:text-gray-900">Cart</a>
            <a href="<?= base_url('admin/dashboard') ?>" class="text-sm  text-gray-900">Admin</a>
        </div>
    </div>
</nav>

<main class="bg-gray-100 min-h-screen py-8">
<div class="container mx-auto py-10 px-6">

    <h1 class="text-3xl font-bold mb-8">
        Checkout
    </h1>

    <form action="<?= base_url('checkout/process') ?>" method="post">

        <input type="hidden" name="ids" value="<?= esc($ids) ?>">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white rounded-2xl p-6">
                    <h2 class="font-bold text-xl mb-5">
                        Informasi Pembeli
                    </h2>

                    <div class="space-y-4">

                        <div>
                            <label class="block mb-2 font-medium">
                                Nama
                            </label>

                            <input
                                type="text"
                                name="name"
                                required
                                class="w-full border rounded-xl px-4 py-3"
                            >
                        </div>

                        <div>
                            <label class="block mb-2 font-medium">
                                Address
                            </label>

                            <textarea
                                name="address"
                                rows="4"
                                required
                                class="w-full border rounded-xl px-4 py-3"
                            ></textarea>
                        </div>

                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6">

                    <h2 class="font-bold text-xl mb-5">
                        Produk
                    </h2>

                    <div class="space-y-5">

                        <?php foreach($cart as $item): ?>

                            <div class="flex gap-4 border-b pb-5">

                                <img
                                    src="<?= base_url($item['image']) ?>"
                                    class="w-24 h-24 object-cover rounded-xl border"
                                >

                                <div class="flex-1">

                                    <h3 class="font-semibold text-lg">
                                        <?= esc($item['product_name']) ?>
                                    </h3>

                                    <p class="text-gray-500 mt-2">
                                        Qty: <?= esc($item['qty']) ?>
                                    </p>

                                    <p class="font-bold text-pink-600 mt-2">
                                        Rp <?= number_format($item['subtotal'], 0, ',', '.') ?>
                                    </p>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    </div>

                </div>

            </div>

            <div>

                <div class="bg-white rounded-2xl p-6 sticky top-5">

                    <h2 class="font-bold text-xl mb-5">
                        Pembayaran
                    </h2>

                    <div class="space-y-3">

                        <label class="flex items-center justify-between border rounded-xl px-4 py-4 cursor-pointer">

                            <div>
                                <p class="font-semibold">
                                    QRIS
                                </p>
                            </div>

                            <input
                                type="radio"
                                name="payment_method"
                                value="qris"
                                checked
                            >

                        </label>

                        <label class="flex items-center justify-between border rounded-xl px-4 py-4 cursor-pointer">

                            <div>
                                <p class="font-semibold">
                                    Virtual Account
                                </p>
                            </div>

                            <input
                                type="radio"
                                name="payment_method"
                                value="virtual_account"
                            >

                        </label>

                    </div>

                    <div class="border-t mt-6 pt-6">

                        <div class="flex justify-between mb-3">
                            <span>Total Barang</span>
                            <span><?= $totalItems ?></span>
                        </div>

                        <div class="flex justify-between mb-5">
                            <span>Total</span>

                            <span class="font-bold text-xl">
                                Rp <?= number_format($total, 0, ',', '.') ?>
                            </span>
                        </div>

                        <button
                            type="submit"
                            class="w-full bg-green-600 hover:bg-green-700 text-white py-4 rounded-xl font-bold cursor-pointer">

                            Bayar Sekarang

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

</body>
</html>