<?php

namespace App\Controllers;

use App\Models\ProductModel;

class CartController extends BaseController
{
    public function index()
    {
        $cart = session()->get('cart') ?? [];
        

        return view('cart/index', [
            'title' => 'WrapStation Store',
            'cart' => $cart
        ]);
    }

    public function add($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->find($id);

        if (!$product) {
            return redirect()->to('/');
        }

        $stock = (int) $product['qty_in_stock'];
        $cart = session()->get('cart') ?? [];

        if (isset($cart[$id])) {

            if ($cart[$id]['qty'] >= $stock) {
                session()->setFlashdata('error', 'Jumlah produk sudah mencapai stok maksimal');
                return redirect()->to('/');
            }

            $cart[$id]['qty']++;
            $cart[$id]['subtotal'] = $cart[$id]['qty'] * $cart[$id]['price'];

        } else {

            if ($stock <= 0) {
                session()->setFlashdata('error', 'Stok produk habis');
                return redirect()->to('/');
            }

            $cart[$id] = [
                'product_id' => $product['product_id'],
                'product_name' => $product['product_name'],
                'image' => $product['image'],
                'price' => $product['price'],
                'qty' => 1,
                'stock' => $stock,
                'subtotal' => $product['price'],
            ];
        }

        session()->set('cart', $cart);
        session()->setFlashdata('success', 'Produk berhasil ditambahkan ke cart');

        return redirect()->back();
    }

    public function remove($id)
    {
        $cart = session()->get('cart') ?? [];

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        session()->set('cart', $cart);

        return redirect()->to('/cart');
    }

    public function increase($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->find($id);

        if (!$product) {
            return redirect()->to('/cart');
        }

        $stock = (int) $product['qty_in_stock'];
        $cart = session()->get('cart') ?? [];

        if (isset($cart[$id])) {

            if ($cart[$id]['qty'] >= $stock) {
                session()->setFlashdata('error', 'Jumlah produk sudah mencapai stok maksimal');
                return redirect()->to('/cart');
            }

            $cart[$id]['qty']++;
            $cart[$id]['subtotal'] = $cart[$id]['qty'] * $cart[$id]['price'];
        }

        session()->set('cart', $cart);

        return redirect()->to('/cart');
    }

    public function decrease($id)
    {
        $cart = session()->get('cart') ?? [];

        if (isset($cart[$id])) {
            $cart[$id]['qty']--;

            if ($cart[$id]['qty'] <= 0) {
                unset($cart[$id]);
            } else {
                $cart[$id]['subtotal'] = $cart[$id]['qty'] * $cart[$id]['price'];
            }
        }

        session()->set('cart', $cart);
        return redirect()->to('/cart');
    }

    public function clear()
    {
        session()->remove('cart');
        return redirect()->to('/cart');
    }

    public function deleteSelected()
    {
        $ids = $this->request->getGet('ids');
        $ids = explode(',', $ids);

        $cart = session()->get('cart') ?? [];

        foreach ($ids as $id) {
            if (isset($cart[$id])) {
                unset($cart[$id]);
            }
        }

        session()->set('cart', $cart);

        return redirect()->to('/cart');
    }
}