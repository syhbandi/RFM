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
