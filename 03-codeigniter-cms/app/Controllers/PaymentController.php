<?php

namespace App\Controllers;

use App\Models\TransactionModel;

class PaymentController extends BaseController
{
    public function index($userId)
    {
        $transactionModel = new TransactionModel();

        $transactions = $transactionModel
            ->where('user_id', $userId)
            ->where('status', 'pending')
            ->findAll();

        if (empty($transactions)) {
            return redirect()->to('/history');
        }

        $paymentMethod = $transactions[0]['payment_method'];
        $total = array_sum(array_column($transactions, 'total_price'));
        $createdAt = strtotime($transactions[0]['created_at']);
        $expiredAt = $createdAt + (60 * 60);

        return view('payment/index', [
            'title' => 'Payment',
            'transactions' => $transactions,
            'userId' => $userId,
            'paymentMethod' => $paymentMethod,
            'total' => $total,
            'expiredAt' => $expiredAt,
            'virtualNumber' => '80777087730164053'
        ]);
    }

    public function paid($userId)
    {
        $transactionModel = new \App\Models\TransactionModel();

        $transactionModel
            ->where('user_id', $userId)
            ->where('status', 'pending')
            ->set(['status' => 'paid'])
            ->update();

        return redirect()->to('/payment/success/' . $userId);
    }

    public function success($userId)
    {
        $transactionModel = new \App\Models\TransactionModel();

        $transactions = $transactionModel
            ->where('user_id', $userId)
            ->where('status', 'paid')
            ->findAll();

        if (empty($transactions)) {
            return redirect()->to('/history');
        }

        $total = array_sum(array_column($transactions, 'total_price'));

        return view('payment/success', [
            'title' => 'Pembayaran Berhasil',
            'transactions' => $transactions,
            'userId' => $userId,
            'total' => $total,
            'paymentMethod' => $transactions[0]['payment_method'],
            'paidAt' => date(
                'd M Y, H:i',
                strtotime($transactions[0]['updated_at'])
            ) . ' WIB'
        ]);
    }
}