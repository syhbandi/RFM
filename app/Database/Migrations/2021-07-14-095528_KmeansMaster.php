<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KmeansMaster extends Migration
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
			'c1' => [
				'type' => 'double'
			],
			'c2' => [
				'type' => 'double'
			],
			'kmeans_his_id' => [
				'type' => 'int',
				'constraint' => 11,
				'unsigned' => true
			],
			'rfm_id' => [
				'type' => 'int',
				'constraint' => 11,
				'unsigned' => true
			]
		];

		$this->forge->addField($fields);
		$this->forge->addPrimaryKey('id');
		$this->forge->addForeignKey('kmeans_his_id', 'kmeans_history', 'id', 'cascade', 'cascade');
		$this->forge->addForeignKey('rfm_id', 'rfm', 'id', 'cascade', 'cascade');
		$this->forge->createTable('kmeans');
	}

	public function down()
	{
		$this->forge->dropTable('kmeans');
	}
}
