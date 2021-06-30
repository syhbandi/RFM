<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Transaksi extends Seeder
{
	public function run()
	{
		$data = [
			[
				'tipe_paket' => 'AO | INET + TLP',
				'deskripsi' => 'internet dan telepon',
				'jumlah_paket' => 2
			],
			[
				'tipe_paket' => 'AO | INET + IPTV',
				'deskripsi' => 'internet dan tv',
				'jumlah_paket' => 2
			],
			[
				'tipe_paket' => 'AO | INET',
				'deskripsi' => 'hanya internet',
				'jumlah_paket' => 1
			],
			[
				'tipe_paket' => 'AO | INET + TLP + IPTV',
				'deskripsi' => 'internet telepon, dan TV',
				'jumlah_paket' => 3
			],
		];

		$this->db->table('paket')->insertBatch($data);
	}
}
