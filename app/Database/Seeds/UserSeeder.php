<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
	public function run()
	{
		$this->db->table('user')->insert([
			'nama' => 'Sri Ayu Ainun',
			'email' => 'sriayuainun.s@gmail.com',
			'password' => \md5('admin'),
			'akses_level' => 'SUPER ADMIN'
		]);
	}
}
