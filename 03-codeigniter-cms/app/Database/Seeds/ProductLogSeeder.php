<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductLogSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'product_id' => 1,
                'action' => 'created',
                'performed_by_user_id' => 1,
                'old_price' => null,
                'new_price' => 750000,
                'old_stock' => null,
                'new_stock' => 10,
                'description' => 'Product created',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'product_id' => 2,
                'action' => 'stock_updated',
                'performed_by_user_id' => 2,
                'old_price' => 350000,
                'new_price' => 350000,
                'old_stock' => 20,
                'new_stock' => 15,
                'description' => 'Stock updated',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('product_logs')->insertBatch($data);
    }
}