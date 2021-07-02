<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pelanggan extends Migration
{
	public function up()
	{
		$fields = [
			'id' => [
				'type' => 'int',
				'constraint' => '11',
				'unsigned' => true,
				'auto_increment' => true
			],
			'nama' => [
				'type' => 'varchar',
				'constraint' => '255',
			],
			'alamat' => [
				'type' => 'text',
				// 'constraint' => '255'
			],
			'jumlah_terpasang' => [
				'type' => 'INT',
				'constraint' => '5'
			],
			'activity_nosa' => [
				'type' => 'varchar',
				'constraint' => 255
			],
			'layanan' => [
				'type' => 'varchar',
				'constraint' => 255
			],
			'tgl_daftar' => [
				'type' => 'datetime',
				// 'constraint' => '\'male\', \'female\''
			],
			'tgl_aktif' => [
				'type' => 'datetime',
				// 'constraint' => '\'male\', \'female\''
			],
			'keterangan' => [
				'type' => 'text',
			],
			'paket_id' => [
				'type' => 'int',
				'constraint' => '11',
				'unsigned' => true
			],
		];

		$this->forge->addField($fields);
		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('paket_id', 'paket', 'id');
		$this->forge->createTable('pelanggan', true);
	}

	public function down()
	{
		$this->forge->dropTable('pelanggan');
	}
}
