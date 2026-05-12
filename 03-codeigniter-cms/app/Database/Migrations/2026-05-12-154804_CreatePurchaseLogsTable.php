<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePurchaseLogsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'purchase_log_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'transaction_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'action' => [
                'type' => 'ENUM',
                'constraint' => ['created', 'updated', 'deleted', 'paid', 'cancelled'],
            ],
            'performed_by_user_id' => [
                'type' => 'INT',
                'unsigned' => true,
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

        $this->forge->addKey('purchase_log_id', true);
        $this->forge->addForeignKey('transaction_id', 'transactions', 'transaction_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('performed_by_user_id', 'users', 'user_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('purchase_logs');
    }

    public function down()
    {
        $this->forge->dropTable('purchase_logs');
    }
}