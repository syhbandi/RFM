<?php

namespace App\Controllers;

use App\Models\DataModel;

class Home extends BaseController
{
	public function index()
	{
		$dataModel = new DataModel();
		$data['dataNOK'] = $dataModel->where('layanan', 'NOK')->where('')->findAll();
		$data['dataOK'] = $dataModel->where('layanan', 'OK')->findAll();
		return view('home', $data);
	}
}
