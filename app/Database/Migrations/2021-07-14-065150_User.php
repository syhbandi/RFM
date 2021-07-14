<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
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
			'email' => [
				'type' => 'varchar',
				'constraint' => '255'
			],
			'password' => [
				'type' => 'text',
			],
			'akses_level' => [
				'type' => 'varchar',
				'constraint' => 255
			],
		];

		$this->forge->addField($fields);
		$this->forge->addKey('id', true);
		$this->forge->createTable('user', true);
	}

	public function down()
	{
		$this->forge->dropTable('user');
	}
}
