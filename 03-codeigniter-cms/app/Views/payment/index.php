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
<div class="max-w-4xl mx-auto py-8 px-6">

    <div class="bg-white rounded-xl p-6">

        <div class="flex justify-between items-start border-b pb-6">
            <div class="flex gap-5">
                <div class="w-12 h-12 rounded-full bg-yellow-400 flex items-center justify-center text-white text-xl font-bold">
                    !
                </div>

                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Bayar sebelum
                    </h1>
                    <p class="text-gray-500">
                        <?= date('d M Y, H:i', $expiredAt) ?> WIB
                    </p>
                </div>
            </div>

           <div 
                id="countdown"
                class="text-sm text-red-500 font-bold">
            </div>
        </div>

        <div class="bg-green-50 text-center text-sm py-3 rounded-lg my-5">
            🎉 Kamu hemat Rp3.000 dari transaksi ini!
        </div>

        <?php if ($paymentMethod === 'qris'): ?>

            <div class="text-center py-6">
                <h2 class="text-lg text-gray-600 mb-4">
                    Scan QRIS untuk pembayaran
                </h2>

                <div class="inline-block border rounded-xl p-4">
                    <img 
                        src="<?= ('https://dummyimage.com/400x400/e5e7eb/111827&text=No+Image') ?>" 
                        class="w-64 h-64 object-contain"
                        alt="QRIS">
                </div>
            </div>

        <?php else: ?>

            <div class="py-4">
                <p class="text-gray-500 mb-1">
                    Nomor Virtual Account
                </p>

                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-900">
                        <?= esc($virtualNumber) ?>
                    </h2>

                    <span class="font-bold text-blue-700">
                        BCA
                    </span>
                </div>
            </div>

        <?php endif; ?>

        <div class="border-t border-b py-5 mt-4">
            <div class="flex justify-between items-center">
                <p class="text-gray-500">
                    Total Tagihan
                </p>

                <p class="text-2xl font-bold text-gray-900">
                    Rp<?= number_format($total, 0, ',', '.') ?>
                </p>
            </div>
        </div>

        <ul class="text-gray-500 text-sm mt-5 space-y-2 list-disc pl-5">
            <li>
                Transfer hanya bisa dilakukan sesuai metode pembayaran yang kamu pilih.
            </li>
            <li>
                Transaksi akan diproses setelah pembayaran berhasil diverifikasi.
            </li>
        </ul>

        <form action="<?= base_url('payment/paid/' . $userId) ?>" method="post" class="mt-6">
            <?= csrf_field() ?>

            <button 
                type="submit"
                id="payButton"
                class="cursor-pointer w-full border border-green-600 text-green-600 py-3 rounded-xl font-bold hover:bg-green-600 hover:text-white transition">
                Sudah Bayar
            </button>
        </form>

    </div>

</div>
<script>
    const expiredAt = <?= $expiredAt * 1000 ?>;

    function updateCountdown() {

        const now = new Date().getTime();

        const distance = expiredAt - now;
        const payButton = document.getElementById('payButton');

        if (distance <= 0) {

            document.getElementById('countdown').innerHTML = 'EXPIRED';
            payButton.disabled = true;
            payButton.classList.remove(
                'border-green-600',
                'text-green-600',
                'hover:bg-green-600',
                'hover:text-white',
                'cursor-pointer'
            );

            payButton.classList.add(
                'bg-gray-300',
                'border-gray-300',
                'text-gray-500',
                'cursor-not-allowed'
            );

            payButton.innerHTML = 'Pembayaran Expired';

            return;
        }

        const hours = Math.floor(
            (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
        );

        const minutes = Math.floor(
            (distance % (1000 * 60 * 60)) / (1000 * 60)
        );

        const seconds = Math.floor(
            (distance % (1000 * 60)) / 1000
        );

        document.getElementById('countdown').innerHTML =
            `${String(hours).padStart(2, '0')} : ` +
            `${String(minutes).padStart(2, '0')} : ` +
            `${String(seconds).padStart(2, '0')}`;
    }

    updateCountdown();

    setInterval(updateCountdown, 1000);
</script>
</body>
</html>