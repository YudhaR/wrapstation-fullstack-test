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

<body class="bg-gray-100">

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
            <a href="<?= base_url('history') ?>" class="text-sm font-semibold hover:text-gray-900">History</a>
            <a href="<?= base_url('cart') ?>" class="text-sm hover:text-gray-900">Cart</a>
            <a href="<?= base_url('admin/dashboard') ?>" class="text-sm  text-gray-900">Admin</a>
        </div>
    </div>
</nav>

<main class="container mx-auto px-6 py-8">
    <div class="max-w-4xl mx-auto py-8 px-6">

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

            <div class="border-b px-6 py-5">
                <h1 class="text-2xl font-bold text-gray-900">
                    Detail Transaksi
                </h1>
            </div>

            <div class="p-6">
                <div class="border-b border-gray-200 pb-6">

                    <div class="flex justify-between items-center">

                        <div>
                            <h2 class="font-bold text-lg text-gray-900">
                                Pesanan Selesai
                            </h2>

                            <p class="text-sm text-gray-500 mt-1">
                                Transaksi berhasil dibayar
                            </p>
                        </div>

                        <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-bold">
                            Berhasil
                        </span>

                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

                    <div>
                        <p class="text-sm text-gray-400">
                            No. Pesanan
                        </p>

                        <p class="font-semibold text-green-600 mt-1">
                            INV<?= date('Ymd', strtotime($transactions[0]['created_at'])) . $user['user_id'] ?>
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-400">
                            Tanggal Pembelian
                        </p>

                        <p class="font-semibold text-gray-900 mt-1">
                            <?= date('d F Y, H:i', strtotime($transactions[0]['updated_at'])) ?> WIB
                        </p>
                    </div>

                </div>

            </div>

            <div class="p-6">
                <div class="border-b border-gray-200 pb-6">

                    <h2 class="font-bold text-lg text-gray-900 mb-5">
                        Detail Produk
                    </h2>

                    <div class="space-y-5">

                        <?php foreach($transactions as $transaction): ?>

                            <div class="flex gap-5 border rounded-xl p-4">

                                <img
                                    src="<?= base_url($transaction['product']['image']) ?>"
                                    class="w-24 h-24 object-cover rounded-xl border">

                                <div class="flex-1">

                                    <h3 class="font-semibold text-gray-900">
                                        <?= esc($transaction['product']['product_name']) ?>
                                    </h3>

                                    <p class="text-sm text-gray-500 mt-2">
                                        Qty <?= esc($transaction['qty']) ?>
                                    </p>

                                    <p class="text-lg font-bold text-gray-900 mt-3">
                                        Rp<?= number_format($transaction['total_price'], 0, ',', '.') ?>
                                    </p>

                                </div>

                                <div>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold capitalize">
                                        <?= esc($transaction['status']) ?>
                                    </span>
                                </div>

                            </div>

                        <?php endforeach; ?>

                    </div>
                </div>

            </div>

            <div class="p-6">
                <div class="border-b border-gray-200 pb-6">

                    <div class="flex justify-between items-start">

                        <div>
                            <h2 class="font-bold text-lg text-gray-900">
                                Info Pengiriman
                            </h2>

                            <div class="mt-4 text-sm text-gray-700">

                                <p class="font-semibold">
                                    <?= esc($user['name']) ?>
                                </p>

                                <p class="mt-2">
                                    <?= nl2br(esc($user['address'])) ?>
                                </p>

                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="p-6">

                <h2 class="font-bold text-lg text-gray-900 mb-5">
                    Rincian Pembayaran
                </h2>

                <div class="space-y-3">

                    <div class="flex justify-between">
                        <span class="text-gray-500">
                            Metode Pembayaran
                        </span>

                        <span class="font-medium">
                            <?= esc($transactions[0]['payment_method']) ?>
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">
                            Total Belanja
                        </span>

                        <span class="font-medium">
                            Rp<?= number_format($total, 0, ',', '.') ?>
                        </span>
                    </div>

                </div>

                <div class="border-t mt-5 pt-5 flex justify-between items-center">

                    <span class="text-xl font-bold text-gray-900">
                        Total Bayar
                    </span>

                    <span class="text-2xl font-bold text-gray-900">
                        Rp<?= number_format($total, 0, ',', '.') ?>
                    </span>

                </div>

            </div>

        </div>
    </div>

</main>

</body>
</html>