<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kmeans extends Migration
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
			'tanggal' => [
				'type' => 'datetime',
			],
			'deskripsi' => [
				'type' => 'text',
			],
			'c1R' => [
				'type' => 'double',
			],
			'c1F' => [
				'type' => 'double',
			],
			'c1M' => [
				'type' => 'double',
			],
			'c2R' => [
				'type' => 'double',
			],
			'c2F' => [
				'type' => 'double',
			],
			'c2M' => [
				'type' => 'double',
			],
			'periode' => [
				'type' => 'varchar',
				'constraint' => 255
			]
		];

		$this->forge->addField($fields);
		$this->forge->addKey('id', true);
		$this->forge->createTable('kmeans_history', true);
	}

	public function down()
	{
		$this->forge->dropTable('kmeans_history');
	}
}
