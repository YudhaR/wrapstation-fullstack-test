<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\UserModel;
use App\Models\ProductModel;

class HistoryController extends BaseController
{
    public function index()
    {
        $transactionModel = new TransactionModel();
        $productModel = new ProductModel();

        $transactions = $transactionModel
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $groupedTransactions = [];

        foreach ($transactions as $transaction) {

            $userId = $transaction['user_id'];

            if (!isset($groupedTransactions[$userId])) {

                $groupedTransactions[$userId] = [
                    'user_id' => $userId,
                    'created_at' => $transaction['created_at'],
                    'status' => $transaction['status'],
                    'payment_method' => $transaction['payment_method'],
                    'items' => [],
                    'total' => 0
                ];
            }

            $product = $productModel->find(
                $transaction['product_id']
            );

            $transaction['product'] = $product;

            $groupedTransactions[$userId]['items'][] = $transaction;

            $groupedTransactions[$userId]['total'] +=
                $transaction['total_price'];
        }

        return view('history/index', [
            'title' => 'Riwayat Transaksi',
            'transactions' => $groupedTransactions
        ]);
    }

    public function detail($userId)
    {
        $transactionModel = new TransactionModel();
        $userModel = new UserModel();
        $productModel = new ProductModel();

        $user = $userModel->find($userId);

        if (!$user) {
            return redirect()->to('/');
        }

        $transactions = $transactionModel
            ->where('user_id', $userId)
            ->findAll();

        if (empty($transactions)) {
            return redirect()->to('/');
        }

        foreach ($transactions as &$transaction) {

            $product = $productModel->find(
                $transaction['product_id']
            );

            $transaction['product'] = $product;
        }

        $total = array_sum(
            array_column($transactions, 'total_price')
        );

        return view('history/detail', [
            'title' => 'Detail Transaksi',
            'user' => $user,
            'transactions' => $transactions,
            'total' => $total
        ]);
    }
}