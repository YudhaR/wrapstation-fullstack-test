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

<main class="bg-gray-100 min-h-screen py-8">
    <div class="container mx-auto px-6">

        <h1 class="text-2xl font-bold text-gray-900 mb-6">Keranjang</h1>

        <?php if (!empty($cart)): ?>

            <?php
                $total = array_sum(array_column($cart, 'subtotal'));
                $totalItems = array_sum(array_column($cart, 'qty'));
            ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 bg-white rounded-xl overflow-hidden">

                    <div class="flex items-center justify-between px-6 py-5 border-b">
                        
                        <div class="flex items-center gap-4">
                            
                            <label class="relative flex items-center cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    id="checkAll"
                                    class="peer hidden"
                                >

                                <div class="w-5 h-5 border-2 border-gray-300 rounded flex items-center justify-center
                                            peer-checked:bg-green-600 peer-checked:border-green-600 transition">
                                    <i class="fa-solid fa-check text-white text-xs hidden peer-checked:block"></i>
                                </div>
                            </label>

                            <p class="font-semibold text-gray-900">
                                Pilih Semua 
                                <span class="font-normal text-gray-500">
                                    (<?= count($cart) ?>)
                                </span>
                            </p>
                        </div>

                        <button 
                            type="button"
                            id="deleteSelected"
                            class="text-red-500 font-semibold text-sm cursor-pointer"
                        >
                            Hapus 
                        </button>
                    </div>

                    <?php foreach ($cart as $item): ?>
                        <div class="flex gap-4 px-6 py-5 border-b last:border-b-0">

                            <div class="pt-8">
                                <label class="relative flex items-center cursor-pointer">

                                    <input 
                                        type="checkbox"
                                        class="cart-checkbox peer hidden"
                                        value="<?= $item['product_id'] ?>"
                                        data-subtotal="<?= $item['subtotal'] ?>"
                                        data-qty="<?= $item['qty'] ?>"
                                    >

                                    <div class="w-5 h-5 border-2 border-gray-300 rounded flex items-center justify-center
                                                peer-checked:bg-green-600
                                                peer-checked:border-green-600
                                                transition">

                                        <i class="fa-solid fa-check text-white text-xs hidden peer-checked:block"></i>

                                    </div>

                                </label>
                            </div>

                            <div class="w-24 h-24 rounded-lg overflow-hidden border bg-gray-100 flex-shrink-0">
                                <img src="<?= base_url($item['image']) ?>"
                                     class="w-full h-full object-cover"
                                     alt="<?= esc($item['product_name']) ?>">
                            </div>

                            <div class="flex-1">
                                <h3 class="text-gray-900 font-medium leading-snug">
                                    <?= esc($item['product_name']) ?>
                                </h3>

                                <p class="text-sm text-gray-500 mt-2">
                                    Qty: <?= esc($item['qty']) ?>
                                </p>

                                <p class="text-xs text-gray-400 mt-1">
                                    Stok tersedia: <?= esc($item['stock'] ?? '-') ?>
                                </p>

                                <div class="flex items-end justify-between mt-5">
                                    <div>
                                        <p class="text-pink-600 font-bold text-lg">
                                            Rp <?= number_format($item['subtotal'], 0, ',', '.') ?>
                                        </p>
                                        <p class="text-sm text-gray-400">
                                            Rp <?= number_format($item['price'], 0, ',', '.') ?> / item
                                        </p>
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <a href="<?= base_url('cart/remove/' . $item['product_id']) ?>"
                                            class="text-gray-400 hover:text-red-500 text-xl">
                                                <i class="fa-regular fa-trash-can"></i>
                                        </a>

                                        <div class="flex items-center border rounded-full px-3 py-1 gap-4 text-gray-700">
                                            <a href="<?= base_url('cart/decrease/' . $item['product_id']) ?>"
                                            class="text-gray-400 hover:text-gray-900">
                                                <i class="fa-solid fa-minus"></i>
                                            </a>

                                            <span class="text-sm"><?= esc($item['qty']) ?></span>

                                            <a href="<?= base_url('cart/increase/' . $item['product_id']) ?>"
                                            class="text-gray-700 hover:text-gray-900">
                                                <i class="fa-solid fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>

                </div>

                <div class="bg-white rounded-xl p-6 h-fit">
                    <h2 class="font-bold text-gray-900 text-lg mb-4">Ringkasan belanja</h2>

                    <div class="flex items-center justify-between pb-4 border-b">
                        <p class="text-gray-700">Total</p>
                        <p class="font-bold text-gray-900" id="selectedTotal">
                            Rp 0
                        </p>
                    </div>

                    <a href="#"
                        id="checkoutButton"
                        class="block text-center mt-6 w-full bg-green-600 text-white py-3 rounded-lg font-bold hover:bg-green-700 transition">
                            Beli (0)
                    </a>
                </div>

            </div>

        <?php else: ?>

            <div class="bg-white rounded-xl p-10 text-center">
                <p class="text-gray-500 mb-4">Cart is empty</p>
                <a href="<?= base_url('/') ?>" class="text-green-600 font-semibold">
                    Continue Shopping
                </a>
            </div>

        <?php endif; ?>

    </div>
</main>


<script>
    const checkAll = document.getElementById('checkAll');
    const checkboxes = document.querySelectorAll('.cart-checkbox');
    const selectedTotal = document.getElementById('selectedTotal');
    const checkoutButton = document.getElementById('checkoutButton');

    function formatRupiah(number) {
        return 'Rp ' + number.toLocaleString('id-ID');
    }

    function updateSummary() {
        let total = 0;
        let totalQty = 0;
        let selectedIds = [];

        checkboxes.forEach(cb => {
            if (cb.checked) {
                total += parseInt(cb.dataset.subtotal);
                totalQty += parseInt(cb.dataset.qty);
                selectedIds.push(cb.value);
            }
        });

        selectedTotal.textContent = formatRupiah(total);
        checkoutButton.textContent = `Beli (${totalQty})`;

        if (selectedIds.length > 0) {
            checkoutButton.href = "<?= base_url('checkout') ?>?ids=" + selectedIds.join(',');
            checkoutButton.classList.remove('bg-gray-400', 'pointer-events-none');
            checkoutButton.classList.add('bg-green-600', 'hover:bg-green-700');
        } else {
            checkoutButton.href = "#";
            checkoutButton.classList.remove('bg-green-600', 'hover:bg-green-700');
            checkoutButton.classList.add('bg-gray-400', 'pointer-events-none');
        }
    }

    checkAll.addEventListener('change', function () {
        checkboxes.forEach(cb => {
            cb.checked = this.checked;
        });

        updateSummary();
    });

    checkboxes.forEach(cb => {
        cb.addEventListener('change', function () {
            const total = checkboxes.length;
            const checked = document.querySelectorAll('.cart-checkbox:checked').length;

            checkAll.checked = total === checked;

            updateSummary();
        });
    });

    document.getElementById('deleteSelected').addEventListener('click', function () {
        let selected = [];

        checkboxes.forEach(cb => {
            if (cb.checked) {
                selected.push(cb.value);
            }
        });

        if (selected.length === 0) {
            alert('Pilih produk terlebih dahulu');
            return;
        }

        window.location.href =
            "<?= base_url('cart/delete-selected') ?>?ids=" + selected.join(',');
    });

    updateSummary();
</script>