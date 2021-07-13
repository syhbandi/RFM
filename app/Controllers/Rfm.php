<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DataModel;
use App\Models\RfmModel;
use DateTime;

class Rfm extends BaseController
{

	public function __construct()
	{
		$this->data = ['title' => 'RFM'];
		$this->rfmModel = new RfmModel();
	}
	public function index()
	{
		return view('rfm/view', $this->data);
	}

	public function loadData()
	{
		$params['draw'] = $_REQUEST['draw'];
		$start = $_REQUEST['start'];
		$length = $_REQUEST['length'];

		$search_value = $_REQUEST['search']['value'];

		if (!empty($search_value)) {
			$total_count = $this->rfmModel->getData($search_value, null, null)->getNumRows();
			$data = $this->rfmModel->search($search_value, $start, $length)->getResult();
		} else {
			$total_count = $this->rfmModel->getData(null, null, null)->getNumRows();
			$data = $this->rfmModel->getData(null, $start, $length)->getResult();
		}

		return json_encode([
			"draw" => intval($params['draw']),
			"recordsTotal" => $total_count,
			"recordsFiltered" => $total_count,
			"data" => $data
		]);
	}

	public function generate()
	{
		// hapus dulu isi table
		$this->rfmModel->emptyTable();

		// ambil data pelanggan
		$dataModel = new DataModel();
		$dataPelanggan = $dataModel->getData()->getResultArray();

		foreach ($dataPelanggan as $pelanggan) {
			// hitung recency
			$tgl_daftar = strtotime($pelanggan['tgl_daftar']);
			$tgl_aktif = strtotime($pelanggan['tgl_aktif']);
			$selisih = $tgl_aktif - $tgl_daftar;
			$recency = $selisih / (24 * 60 * 60);

			// hitung frequency
			$frequency = $pelanggan['jumlah_paket'] == $pelanggan['jumlah_terpasang'] ? 1 : 0;

			// hitung monetary
			$monetary = $pelanggan['jumlah_terpasang'];

			$this->rfmModel->save([
				'r' => $recency,
				'f' => $frequency,
				'm' => $monetary,
				'pelanggan_id' => $pelanggan['id'],
			]);
		}

		$this->session->setFlashdata('sukses', 'Generate Selesai');
		return \json_encode([
			'success' => true,
			'redirect' => '/rfm'
		]);
	}

	public function tes()
	{
		$dataModel = new DataModel();
		$dataPelanggan = $dataModel->getData()->getResultArray();
		$tgl_daftar = strtotime($dataPelanggan[0]['tgl_daftar']);
		$tgl_aktif = strtotime($dataPelanggan[0]['tgl_aktif']);
		$recency = $tgl_aktif - $tgl_daftar;
		echo $recency / (24 * 60 * 60);
	}
}
