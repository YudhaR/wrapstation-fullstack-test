<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductLogsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'product_log_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'product_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'action' => [
                'type' => 'ENUM',
                'constraint' => ['created', 'updated', 'deleted', 'stock_updated', 'price_updated'],
            ],
            'performed_by_user_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'old_price' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'null' => true,
            ],
            'new_price' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'null' => true,
            ],
            'old_stock' => [
                'type' => 'INT',
                'null' => true,
            ],
            'new_stock' => [
                'type' => 'INT',
                'null' => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('product_log_id', true);
        $this->forge->addForeignKey('product_id', 'products', 'product_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('performed_by_user_id', 'users', 'user_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('product_logs');
    }

    public function down()
    {
        $this->forge->dropTable('product_logs');
    }
}