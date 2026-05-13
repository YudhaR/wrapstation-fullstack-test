<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => 1,
                'product_id' => 1,
                'payment_method' => 'qris',
                'qty' => 2,
                'status' => 'pending',
                'price' => 750000,
                'total_price' => 1500000,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 2,
                'product_id' => 2,
                'payment_method' => 'virtual_account',
                'qty' => 1,
                'status' => 'paid',
                'price' => 350000,
                'total_price' => 350000,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('transactions')->insertBatch($data);
    }
}