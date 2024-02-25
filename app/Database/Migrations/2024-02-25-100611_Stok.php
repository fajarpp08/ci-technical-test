<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Stok extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_produk' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'ukuran' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'stok' => [
                'type' => 'INT',
            ],
            'harga' => [
                'type' => 'INT',
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id_produk', 'produk', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('stok');
    }


    public function down()
    {
        $this->forge->dropTable('stok');
    }
}
