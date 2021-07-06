<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use phpDocumentor\Reflection\Types\This;

class Rfm extends BaseController
{
	public function __construct()
	{
		$this->data['title'] = 'RFM';
		$this->rfmModel = model('RfmModel');
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
			$total_count = $this->rfmModel->search($search_value)->getNumRows();
			$data = $this->rfmModel->search($search_value, $start, $length)->getResult();
		} else {
			$total_count = $this->rfmModel->get()->getNumRows();
			// $data = $this->rfmModel->limit($length, $start)->get()->getResult();
			$data = $this->rfmModel->getData(null, $start, $length)->getResult();
		}

		return json_encode([
			"draw" => intval($params['draw']),
			"recordsTotal" => $total_count,
			"recordsFiltered" => $total_count,
			"data" => $data
		]);
	}
}
