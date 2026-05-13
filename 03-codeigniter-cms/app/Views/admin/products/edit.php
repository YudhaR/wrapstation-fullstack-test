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

        <aside class="w-64 bg-white border-r border-gray-200 min-h-screen hidden lg:block">
            <div class="p-6">
                <p class="text-sm text-gray-400 font-medium mb-4">
                    Main
                </p>

                <div class="space-y-2">
                    <a href="<?= base_url('admin/dashboard') ?>"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-100 transition">
                        <i class="fa-solid fa-house text-sm"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="<?= base_url('admin/products') ?>"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl bg-red-50 text-red-500 font-medium">
                        <i class="fa-solid fa-cube text-sm"></i>
                        <span>Inventory</span>
                    </a>

                    <a href="<?= base_url('admin/products/create') ?>"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-100 transition">
                        <i class="fa-solid fa-plus text-sm"></i>
                        <span>Add Product</span>
                    </a>

                </div>
            </div>
        </aside>

        <div class="flex-1 py-8">
            <div class="container mx-auto px-6">

                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">
                            Edit Product
                        </h1>

                        <p class="text-gray-500 mt-1">
                            lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </p>
                    </div>

                    <a href="<?= base_url('admin/products') ?>"
                       class="border border-gray-300 text-gray-700 px-5 py-3 rounded-xl font-medium hover:bg-gray-100 transition">
                        Back to Inventory
                    </a>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">

                    <form action="<?= base_url('admin/products/update/' . $product['product_id']) ?>"
                          method="post"
                          enctype="multipart/form-data">

                        <?= csrf_field() ?>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                            <div class="lg:col-span-2 space-y-5">

                                <div>
                                    <label class="block mb-2 font-medium text-gray-700">
                                        Product Name
                                    </label>

                                    <input
                                        type="text"
                                        name="product_name"
                                        value="<?= esc($product['product_name']) ?>"
                                        required
                                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-900">
                                </div>

                                <div>
                                    <label class="block mb-2 font-medium text-gray-700">
                                        Description
                                    </label>

                                    <textarea
                                        name="description"
                                        rows="5"
                                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-900"><?= esc($product['description']) ?></textarea>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                    <div>
                                        <label class="block mb-2 font-medium text-gray-700">
                                            Price
                                        </label>

                                        <input
                                            type="number"
                                            name="price"
                                            value="<?= esc($product['price']) ?>"
                                            required
                                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-900">
                                    </div>

                                    <div>
                                        <label class="block mb-2 font-medium text-gray-700">
                                            Stock
                                        </label>

                                        <input
                                            type="number"
                                            name="qty_in_stock"
                                            value="<?= esc($product['qty_in_stock']) ?>"
                                            required
                                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-900">
                                    </div>

                                </div>

                            </div>

                            <div>
                                <label class="block mb-2 font-medium text-gray-700">
                                    Product Image
                                </label>

                                <?php
                                    $image = !empty($product['image'])
                                        ? base_url($product['image'])
                                        : 'https://dummyimage.com/400x400/e5e7eb/111827&text=No+Image';
                                ?>

                                <div class="border border-gray-200 rounded-2xl p-4 bg-gray-50">
                                    <img
                                        src="<?= esc($image) ?>"
                                        class="w-full h-64 object-cover rounded-xl border border-gray-200 bg-white"
                                        alt="<?= esc($product['product_name']) ?>">

                                    <input
                                        type="file"
                                        name="image"
                                        accept="image/*"
                                        class="mt-4 w-full border border-gray-300 rounded-xl px-4 py-3 bg-white">
                                </div>
                            </div>

                        </div>

                        <div class="border-t border-gray-200 mt-8 pt-6 flex items-center justify-end gap-3">

                            <a href="<?= base_url('admin/products') ?>"
                               class="border border-gray-300 text-gray-700 px-6 py-3 rounded-xl font-medium hover:bg-gray-100 transition">
                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="bg-gray-900 text-white px-6 py-3 rounded-xl font-medium hover:bg-gray-700 transition cursor-pointer">
                                Update Product
                            </button>

                        </div>

                    </form>

                </div>

            </div>
        </div>

    </div>
</main>

</body>
</html>