<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TransactionModel;
use App\Models\ProductModel;

class CheckoutController extends BaseController
{
    public function index()
    {
        $ids = $this->request->getGet('ids');

        if (!$ids) {
            return redirect()->to('/cart');
        }

        $selectedIds = explode(',', $ids);

        $cart = session()->get('cart') ?? [];

        $selectedCart = [];

        foreach ($selectedIds as $id) {

            if (isset($cart[$id])) {
                $selectedCart[$id] = $cart[$id];
            }

        }

        if (empty($selectedCart)) {
            return redirect()->to('/cart');
        }

        $total = array_sum(array_column($selectedCart, 'subtotal'));
        $totalItems = array_sum(array_column($selectedCart, 'qty'));

        return view('checkout/index', [
            'title' => 'Checkout',
            'cart' => $selectedCart,
            'total' => $total,
            'totalItems' => $totalItems,
            'ids' => $ids
        ]);
    }

    public function process()
    {
        $userModel = new UserModel();
        $transactionModel = new TransactionModel();
        $productModel = new ProductModel();

        $name = $this->request->getPost('name');
        $address = $this->request->getPost('address');
        $paymentMethod = $this->request->getPost('payment_method');

        $ids = explode(',', $this->request->getPost('ids'));

        $cart = session()->get('cart') ?? [];

        $selectedCart = [];

        foreach ($ids as $id) {

            if (isset($cart[$id])) {
                $selectedCart[$id] = $cart[$id];
            }

        }

        if (empty($selectedCart)) {
            return redirect()->to('/cart');
        }

        $userModel->insert([
            'name' => $name,
            'address' => $address,
        ]);

        $userId = $userModel->getInsertID();

        foreach ($selectedCart as $item) {

            $product = $productModel->find($item['product_id']);

            if (!$product) {
                continue;
            }

            $currentStock = (int) $product['qty_in_stock'];
            $buyQty = (int) $item['qty'];

            if ($buyQty > $currentStock) {

                session()->setFlashdata(
                    'error',
                    $product['product_name'] . ' stok tidak mencukupi'
                );

                return redirect()->to('/cart');
            }

            $transactionModel->insert([
                'user_id' => $userId,
                'product_id' => $item['product_id'],
                'payment_method' => $paymentMethod,
                'status' => 'pending',
                'qty' => $buyQty,
                'price' => $item['price'],
                'total_price' => $item['subtotal'],
            ]);

            $productModel->update($item['product_id'], [
                'qty_in_stock' => $currentStock - $buyQty
            ]);

            unset($cart[$item['product_id']]);
        }

        session()->set('cart', $cart);

        return redirect()->to('/payment/' . $userId);
    }
}