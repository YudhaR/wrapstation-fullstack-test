<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\TransactionModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $transactionModel = new TransactionModel();

        $products = $productModel->findAll();

        $paidTransactions = $transactionModel
            ->where('status', 'paid')
            ->findAll();

        $totalProfit = array_sum(array_column($paidTransactions, 'total_price'));
        $totalProductSale = array_sum(array_column($paidTransactions, 'qty'));
        $totalStock = array_sum(array_column($products, 'qty_in_stock'));

        $lowStockProducts = $productModel
            ->orderBy('qty_in_stock', 'ASC')
            ->limit(5)
            ->findAll();

        $recentSales = $transactionModel
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->findAll();

        foreach ($recentSales as &$sale) {
            $sale['product'] = $productModel->find($sale['product_id']);
        }

        $topSelling = [];

        foreach ($paidTransactions as $transaction) {

            $productId = $transaction['product_id'];

            if (!isset($topSelling[$productId])) {

                $product = $productModel->find($productId);

                if (!$product) {
                    continue;
                }

                $topSelling[$productId] = [
                    'product' => $product,
                    'total_qty' => 0,
                    'total_sales' => 0
                ];
            }

            $topSelling[$productId]['total_qty'] += $transaction['qty'];

            $topSelling[$productId]['total_sales'] +=
                $transaction['total_price'];
        }

        usort($topSelling, function ($a, $b) {
            return $b['total_qty'] <=> $a['total_qty'];
        });

        $topSelling = array_slice($topSelling, 0, 5);

        return view('admin/dashboard/index', [
            'title' => 'Admin Dashboard',
            'totalProfit' => $totalProfit,
            'totalProductSale' => $totalProductSale,
            'totalStock' => $totalStock,
            'topSelling' => $topSelling,
            'lowStockProducts' => $lowStockProducts,
            'recentSales' => $recentSales,
        ]);
    }
}