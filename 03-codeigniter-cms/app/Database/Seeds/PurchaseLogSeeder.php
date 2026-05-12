<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PurchaseLogSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'transaction_id' => 1,
                'action' => 'created',
                'performed_by_user_id' => 1,
                'description' => 'Transaction created successfully',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'transaction_id' => 2,
                'action' => 'paid',
                'performed_by_user_id' => 2,
                'description' => 'Transaction paid successfully',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('purchase_logs')->insertBatch($data);
    }
}