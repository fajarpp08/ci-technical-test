<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Produk extends Migration
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
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
            ],
            'deskripsi' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'gambar' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'gambar2' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'gambar3' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'kategori' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'url_slug' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('kategori', 'kategori', 'id_kategori', 'CASCADE', 'CASCADE');
        $this->forge->createTable('produk');
    }


    public function down()
    {
        $this->forge->dropTable('produk');
    }
}
