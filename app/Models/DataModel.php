<?php

namespace App\Models;

use CodeIgniter\Model;

class DataModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'pelanggan';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['nama', 'alamat', 'jumlah_terpasang', 'activity_nosa', 'layanan', 'keterangan', 'tgl_daftar', 'tgl_aktif', 'paket_id'];

	// Dates
	protected $useTimestamps        = false;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];

	public function search($key, $start = null, $length = null)
	{
		$arrLike = [
			'nama' => $key,
			'alamat' => $key,
			'jumlah_terpasang' => $key,
			'activity_nosa' => $key,
			'layanan' => $key,
			'keterangan' => $key,
			'tgl_daftar' => $key,
			'tgl_aktif' => $key,
		];

		$this->like('pelanggan.id', $key);
		$this->orLike($arrLike);
		if ($start != null || $length != null) {
			$this->limit($length, $start);
		}
		return $this->get();
	}

	public function getData($key = '', $start, $length)
	{
		$arrLike = [
			'pelanggan.nama' => $key,
			'pelanggan.alamat' => $key,
			'pelanggan.jumlah_terpasang' => $key,
			'pelanggan.activity_nosa' => $key,
			'pelanggan.layanan' => $key,
			'pelanggan.keterangan' => $key,
			'pelanggan.tgl_daftar' => $key,
			'pelanggan.tgl_aktif' => $key,
			'paket.tipe_paket' => $key,
			// 'jumlah_paket' => $key,
		];
		$builder = $this->db->table($this->table);
		$builder->select('pelanggan.*, paket.tipe_paket, paket.deskripsi, paket.jumlah_paket');
		$builder->join('paket', 'paket.id = ' . $this->table . '.paket_id');
		if ($key != '') {
			$builder->like('pelanggan.id', $key);
			$builder->orLike($arrLike);
		}
		$builder->limit($length, $start);
		$builder->orderBy('pelanggan.id', 'asc');
		return $builder->get();
	}

	public function deleteAll()
	{
		$builder = $this->db->table($this->table);
		return $builder->emptyTable();
	}
}
