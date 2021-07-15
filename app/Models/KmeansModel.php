<?php

namespace App\Models;

use CodeIgniter\Model;

class KmeansModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'kmeans';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['c1', 'c2', 'kmeans_his_id', 'rfm_id', 'cluster'];

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

	public function getData($kmeans_his_id)
	{
		$builder = $this->db->table($this->table);
		$builder->select('kmeans.*, rfm.r, rfm.f, rfm.m, pelanggan.nama');
		$builder->join('rfm', 'kmeans.rfm_id = rfm.id');
		$builder->join('pelanggan', 'rfm.pelanggan_id = pelanggan.id');
		$builder->where('kmeans_his_id', $kmeans_his_id);
		return $builder->get();
	}
}
