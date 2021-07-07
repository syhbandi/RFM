<?php

namespace App\Models;

use CodeIgniter\Model;

class RfmModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'rfm';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['r', 'f', 'm', 'pelanggan_id'];

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

	public function getData($key = null, $start = null, $length = null)
	{
		$arrLike = [
			'pelanggan.nama' => $key,
			'rfm.r' => $key,
			'rfm.f' => $key,
			'rfm.m' => $key,
		];
		$builder = $this->db->table($this->table);
		$builder->select('pelanggan.nama, rfm.*');
		$builder->join('pelanggan', 'pelanggan.id = ' . $this->table . '.pelanggan_id');
		if ($key != '') {
			$builder->orLike($arrLike);
		}
		if ($start != '' || $length != '') {
			$builder->limit($length, $start);
		}
		return $builder->get();
	}

	public function EmptyTable()
	{
		$builder = $this->db->table($this->table);
		return $builder->emptyTable();
	}
}
