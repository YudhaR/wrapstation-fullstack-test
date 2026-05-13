<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title><?= esc($title) ?></title>

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet"
          href="<?= base_url('assets/css/output.css') ?>">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
            <a href="<?= base_url('history') ?>" class="text-sm font-semibold hover:text-gray-900">History</a>
            <a href="<?= base_url('cart') ?>" class="text-sm font-semibold hover:text-gray-900">Cart</a>
            <a href="<?= base_url('admin/dashboard') ?>" class="text-sm  text-gray-900">Admin</a>
        </div>
    </div>
</nav>

<main class="bg-gray-100 min-h-screen py-8">

    <div class="container mx-auto px-6">

        <h1 class="text-3xl font-bold text-gray-900 mb-8">
            Daftar Transaksi
        </h1>

        <div class="space-y-5">

            <?php if(!empty($transactions)): ?>

                <?php foreach($transactions as $transaction): ?>

                    <?php
                        $firstItem = $transaction['items'][0];
                        $product = $firstItem['product'];
                        $firstItemProduct = $firstItem['qty'];;

                        $invoice =
                            'INV' .
                            date(
                                'Ymd',
                                strtotime($transaction['created_at'])
                            ) .
                            $transaction['user_id'];

                        $totalItems = count($transaction['items']);
                    ?>

                    <div class="bg-white rounded-2xl border shadow-sm p-6">

                        <div class="flex items-center gap-4 flex-wrap">

                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-bag-shopping text-green-600"></i>

                                <span class="font-bold text-gray-900">
                                    Belanja
                                </span>
                            </div>

                            <span class="text-sm text-gray-500">
                                <?= date(
                                    'd M Y',
                                    strtotime($transaction['created_at'])
                                ) ?>
                            </span>

                            <?php
                                $status = strtolower($transaction['status']);

                                $badgeClass =
                                    $status === 'pending'
                                        ? 'bg-yellow-100 text-yellow-700'
                                        : 'bg-green-100 text-green-700';
                            ?>

                            <span class="<?= $badgeClass ?> px-3 py-1 rounded-full text-xs font-bold capitalize">
                                <?= esc($transaction['status']) ?>
                            </span>

                            <span class="text-sm text-gray-400">
                                <?= esc($invoice) ?>
                            </span>

                        </div>

                        <div class="mt-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                            <div class="flex gap-5">

                                <img
                                    src="<?= base_url($product['image']) ?>"
                                    class="w-24 h-24 object-cover rounded-xl border">

                                <div>

                                    <h2 class="font-bold text-xl text-gray-900 line-clamp-2">
                                        <?= esc($product['product_name']) ?>
                                    </h2>

                                    <p class="text-gray-500 mt-2">
                                        <?= $firstItemProduct ?> barang
                                        x
                                        Rp<?= number_format($firstItem['price'], 0, ',', '.') ?>
                                    </p>

                                    <?php if($totalItems > 1): ?>
                                        <p class="text-gray-400 mt-2 text-sm">
                                            +<?= $totalItems - 1 ?> produk lainnya
                                        </p>
                                    <?php endif; ?>

                                </div>

                            </div>

                            <div class="lg:border-l lg:pl-8 flex flex-col justify-between min-w-[220px]">

                                <div>
                                    <p class="text-sm text-gray-500">
                                        Total Belanja
                                    </p>

                                    <p class="text-2xl font-bold text-gray-900 mt-1">
                                        Rp<?= number_format($transaction['total'], 0, ',', '.') ?>
                                    </p>
                                </div>

                                <?php if($status === 'pending'): ?>

                                    <a href="<?= base_url('payment/' . $transaction['user_id']) ?>"
                                    class="mt-5 inline-flex items-center justify-center
                                            border border-yellow-500 text-yellow-600
                                            px-5 py-3 rounded-xl font-bold
                                            hover:bg-yellow-500 hover:text-white transition">

                                        Lanjutkan Pembayaran

                                    </a>

                                <?php else: ?>

                                    <a href="<?= base_url('history/' . $transaction['user_id']) ?>"
                                    class="mt-5 inline-flex items-center justify-center
                                            border border-green-600 text-green-600
                                            px-5 py-3 rounded-xl font-bold
                                            hover:bg-green-600 hover:text-white transition">

                                        Lihat Detail Transaksi

                                    </a>

                                <?php endif; ?>

                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="bg-white rounded-2xl border p-10 text-center">

                    <i class="fa-solid fa-box-open text-5xl text-gray-300"></i>

                    <h2 class="text-xl font-bold text-gray-900 mt-5">
                        Belum Ada Transaksi
                    </h2>

                    <p class="text-gray-500 mt-2">
                        Yuk mulai belanja sekarang
                    </p>

                    <a href="<?= base_url('/') ?>"
                       class="inline-block mt-6 bg-green-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-green-700 transition">

                        Belanja Sekarang

                    </a>

                </div>

            <?php endif; ?>

        </div>

    </div>

</main>

</body>
</html>