<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Rfm extends Migration
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
			'r' => [
				'type' => 'double'
			],
			'f' => [
				'type' => 'double'
			],
			'm' => [
				'type' => 'double'
			],
			'pelanggan_id' => [
				'type' => 'int',
				'constraint' => 11,
				'unsigned' => true
			]
		];

		$this->forge->addField($fields);
		$this->forge->addPrimaryKey('id');
		$this->forge->addForeignKey('pelanggan_id', 'pelanggan', 'id', 'cascade', 'cascade');
		$this->forge->createTable('rfm');
	}

	public function down()
	{
		$this->forge->dropTable('rfm');
	}
}
