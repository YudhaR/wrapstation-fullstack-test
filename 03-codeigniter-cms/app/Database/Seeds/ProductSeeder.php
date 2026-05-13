<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'product_name' => 'Mechanical Keyboard',
                'image' => 'uploads/products/keyboard.jpg',
                'description' => 'High quality mechanical keyboard for gaming and productivity',
                'qty_in_stock' => 10,
                'price' => 750000,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'product_name' => 'Gaming Mouse',
                'image' => 'uploads/products/mouse.jpg',
                'description' => 'High quality gaming mouse for precise control and comfort',
                'qty_in_stock' => 15,
                'price' => 350000,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('products')->insertBatch($data);
    }
}