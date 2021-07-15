<?php

namespace App\Controllers;

use App\Models\DataModel;
use App\Models\KmeansHistory;
use App\Models\KmeansModel;

class Home extends BaseController
{
	public function index()
	{
		$kmeansModel = new KmeansModel();
		$kmeansHistory = new KmeansHistory();
		$data['periode'] = $kmeansHistory->orderBy('tanggal', 'DESC')->findAll(5);
		$data['kmeans'] = $kmeansModel->findAll(5);
		return view('home', $data);
	}
}
