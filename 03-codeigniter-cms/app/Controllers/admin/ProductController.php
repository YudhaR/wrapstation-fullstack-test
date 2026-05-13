<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class ProductController extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();

        $products = $productModel
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('admin/products/index', [
            'title' => 'Inventory',
            'products' => $products
        ]);
    }

    public function delete($id)
    {
        $productModel = new ProductModel();

        $product = $productModel->find($id);

        if (!$product) {
            return redirect()->to('/admin/products')
                ->with('error', 'Product tidak ditemukan');
        }

        if (!empty($product['image'])) {

            $imagePath = FCPATH . $product['image'];

            if (file_exists($imagePath) && is_file($imagePath)) {
                unlink($imagePath);
            }
        }

        $productModel->delete($id);

        return redirect()->to('/admin/products')
            ->with('success', 'Product berhasil dihapus');
    }
    
    public function create()
    {
        return view('admin/products/create', [
            'title' => 'Add Product'
        ]);
    }

    public function store()
    {
        $productModel = new \App\Models\ProductModel();

        $imagePath = null;
        $image = $this->request->getFile('image');

        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move(FCPATH . 'uploads/products', $newName);

            $imagePath = 'uploads/products/' . $newName;
        }

        $productModel->insert([
            'product_name' => $this->request->getPost('product_name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'qty_in_stock' => $this->request->getPost('qty_in_stock'),
            'image' => $imagePath,
        ]);

        return redirect()->to('/admin/products')
            ->with('success', 'Product berhasil ditambahkan');
    }
    public function edit($id)
    {
        $productModel = new ProductModel();

        $product = $productModel->find($id);

        if (!$product) {
            return redirect()->to('/admin/products')
                ->with('error', 'Product tidak ditemukan');
        }

        return view('admin/products/edit', [
            'title' => 'Edit Product',
            'product' => $product
        ]);
    }

    public function update($id)
    {
        $productModel = new ProductModel();

        $product = $productModel->find($id);

        if (!$product) {
            return redirect()->to('/admin/products')
                ->with('error', 'Product tidak ditemukan');
        }

        $imagePath = $product['image'];

        $image = $this->request->getFile('image');

        if ($image && $image->isValid() && !$image->hasMoved()) {

            if (!empty($product['image'])) {
                $oldImage = FCPATH . $product['image'];

                if (file_exists($oldImage) && is_file($oldImage)) {
                    unlink($oldImage);
                }
            }

            $newName = $image->getRandomName();
            $image->move(FCPATH . 'uploads/products', $newName);

            $imagePath = 'uploads/products/' . $newName;
        }

        $productModel->update($id, [
            'product_name' => $this->request->getPost('product_name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'qty_in_stock' => $this->request->getPost('qty_in_stock'),
            'image' => $imagePath,
        ]);

        return redirect()->to('/admin/products')
            ->with('success', 'Product berhasil diupdate');
    }
}