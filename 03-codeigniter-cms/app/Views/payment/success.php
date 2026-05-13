<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= base_url('assets/css/output.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
    <div class="max-w-4xl mx-auto py-8 px-6">

        <div class="bg-white rounded-xl p-6">

            <div class="text-center border-b pb-8">

                <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-5">
                    <i class="fa-solid fa-check text-white text-4xl"></i>
                </div>

                <h1 class="text-2xl font-bold text-gray-900">
                    Pembayaran Berhasil!
                </h1>

                <p class="text-sm text-gray-400 mt-2">
                    <?= esc($paidAt) ?>
                </p>

                <div class="mt-8">
                    <div class="w-full h-48 bg-blue-50 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-box-open text-blue-300 text-7xl"></i>
                    </div>
                </div>

                <a href="<?= base_url('history/' . $userId) ?>"
                class="inline-block mt-5 text-sm font-semibold text-green-600 hover:underline">
                    Lihat Resi
                </a>

            </div>

            <div class="pt-8 text-center">

                <p class="text-sm text-gray-400 mb-2">
                    Tagihan
                </p>

                <h2 class="font-bold text-gray-900 text-xl">
                    Gaming Store
                </h2>

                <p class="text-sm text-gray-500 mt-2">
                    User ID: <?= esc($userId) ?> -
                    <?= esc($paymentMethod) ?>
                </p>

                <p class="text-sm text-gray-400 mt-6">
                    Jumlah Bayar
                </p>

                <p class="text-3xl font-bold text-gray-900 mt-2">
                    Rp<?= number_format($total, 0, ',', '.') ?>
                </p>

                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">

                    <a href="<?= base_url('history') ?>"
                       class="block w-full bg-green-600 text-white py-3 rounded-xl font-bold hover:bg-green-700 transition">
                        Lihat Riwayat
                    </a>

                    <a href="<?= base_url('/') ?>"
                       class="block w-full border border-gray-300 text-gray-700 py-3 rounded-xl font-bold hover:bg-gray-100 transition">
                        Kembali Belanja
                    </a>

                </div>

            </div>

        </div>

    </div>
</main>

</body>
</html>