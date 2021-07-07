<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DataModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Data extends BaseController
{
	public function __construct()
	{
		$this->dataModel = new DataModel();
		$this->data['title'] = 'Data';
	}

	public function index()
	{
		return \view('data/view', $this->data);
	}

	public function loadData()
	{
		$params['draw'] = $this->request->getVar('draw');
		$start = $_REQUEST['start'];
		$length = $_REQUEST['length'];

		$search_value = $_REQUEST['search']['value'];

		if (!empty($search_value)) {
			$total_count = $this->dataModel->getData($search_value, $start, $length)->getNumRows();
			$data = $this->dataModel->getData($search_value, $start, $length)->getResult();
		} else {
			$total_count = $this->dataModel->getData(null, $start, $length)->getNumRows();
			$data = $this->dataModel->getData(null, $start, $length)->getResult();
		}

		return json_encode([
			"draw" => intval($params['draw']),
			"recordsTotal" => $total_count,
			"recordsFiltered" => $total_count,
			"data" => $data
		]);
	}

	public function save()
	{
		// return json_encode(['tes' => $this->request->getVar()]);
		// set validation rules
		$rules = [
			'nama' => ['label' => 'Nama', 'rules'  => 'required', 'errors' => ['required' => '{field} harus diisi']],
			'alamat' => ['label' => 'deskripsi', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
			'jumlah_terpasang' => ['label' => 'jumlah terpasang', 'rules'  => 'required', 'errors' => ['required' => '{field} harus diisi']],
			'tgl_daftar' => ['label' => 'tgl. daftar', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
			'tgl_aktif' => ['label' => 'tgl. aktif', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
			'activity_nosa' => ['label' => 'Activity NOSA', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
			'paket' => ['label' => 'tipe transaksi', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
			'layanan' => ['label' => 'layanan', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
		];

		// lakukan validasi -> jika gagal kembalikan respon error -> jika berhasil eksekusi code selanjutnya
		if (!$this->validate($rules)) {
			return \json_encode([
				'success' => false,
				'validator' => false,
				'msg' => $this->validator->getErrors(),
				'tokenCSRF' => csrf_hash(),
			]);
		}

		// return \json_encode($this->request->getVar());
		$id = $this->request->getPost('id');
		// simpan data ke db melalui model
		$save = $this->dataModel->save([
			'id' => $id,
			'nama' => $this->request->getPost('nama'),
			'alamat' => $this->request->getPost('alamat'),
			'jumlah_terpasang' => $this->request->getPost('jumlah_terpasang'),
			'activity_nosa' => $this->request->getPost('activity_nosa'),
			'layanan' => $this->request->getPost('layanan'),
			'tgl_daftar' => $this->request->getPost('tgl_daftar'),
			'tgl_aktif' => $this->request->getPost('tgl_aktif'),
			'paket_id' => $this->request->getPost('paket'),
		]);

		// berhasil simpan kembalikan flashdata dan status berhasil
		if ($save) {
			$msg = $id != '' ? 'Data diperbaharui' : 'Data Baru ditambahkan!';
			$this->session->setFlashdata('sukses', $msg);
			return \json_encode([
				'success' => true,
				'redirect' => '/data'
			]);
		}

		// jika gagal simpan kembalikan error
		return \json_encode([
			'success' => false,
			'msg' => 'Error saat menyimpan data'
		]);
	}

	public function add()
	{
		$paket = model('PaketModel');
		$this->data['subtitle'] = 'Add';
		$this->data['dataPaket'] = $paket->findAll();
		return view('data/add', $this->data);
	}

	public function update($id)
	{
		$paket = \model('PaketModel');
		$this->data['subtitle'] = 'Update';
		$this->data['dataPaket'] = $paket->findAll();
		$this->data['dataPelanggan'] = $this->dataModel->find($id);
		return \view('data/update', $this->data);
	}

	public function delete()
	{
		$id = $this->request->getVar('id');
		$hapus = $id != '' ? $this->dataModel->delete(['id' => $id]) : $this->dataModel->deleteAll();
		if ($hapus) {
			$this->session->setFlashdata('sukses', 'Data dihapus!');
			return \json_encode([
				'success' => true,
				'msg' => 'Berhasil Menghapus data',
				'icon' => 'success'
			]);
		}

		return \json_encode([
			'success' => false,
			'msg' => 'Gagal menghapus data',
			'icon' => 'error'
		]);
	}

	public function exportTemplate()
	{
		$fileName = 'Format Import.xlsx';
		$spreadsheet = new Spreadsheet();

		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Nama');
		$sheet->setCellValue('B1', 'Alamat');
		$sheet->setCellValue('C1', 'tipe paket');
		$sheet->setCellValue('D1', 'Activity NOSA');
		$sheet->setCellValue('E1', 'Jumlah Terpasang');
		$sheet->setCellValue('F1', 'Layanan');
		$sheet->setCellValue('G1', 'Tgl. Daftar');
		$sheet->setCellValue('H1', 'Tgl. Aktif');
		$writer = new Xlsx($spreadsheet);
		$filepath = $fileName;

		$writer->save($filepath);
		header("Content-Type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');

		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($filepath));
		flush(); // Flush system output buffer
		readfile($filepath);

		exit;
	}

	// insert batch dari file excel
	public function uploadData()
	{
		$file = $this->request->getFile("fileExcel");
		$ext = $file->getClientExtension();
		$reader = $ext == 'xls' ? new \PhpOffice\PhpSpreadsheet\Reader\Xls() : new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$spreadsheet = $reader->load($file);
		$TempData = $spreadsheet->getActiveSheet()->toArray();
		array_shift($TempData);
		$data = [];

		for ($i = 0; $i < count($TempData); $i++) {
			$data[$i]['nama'] = $TempData[$i][0];
			$data[$i]['alamat'] = $TempData[$i][1];
			$data[$i]['paket_id'] = (trim($TempData[$i][2]) == 'AO | INET + TLP' ? 1 : (trim($TempData[$i][2]) == 'AO | INET + IPTV' ? 2 : (trim($TempData[$i][2]) == 'AO | INET' ? 3 : 4)));
			$data[$i]['activity_nosa'] = $TempData[$i][3];
			$data[$i]['jumlah_terpasang'] = $TempData[$i][4];
			$data[$i]['layanan'] = $TempData[$i][5];
			$data[$i]['tgl_daftar'] = date_format(date_create($TempData[$i][6]), "Y-m-d H:i:s");
			$data[$i]['tgl_aktif'] = date_format(date_create($TempData[$i][7]), "Y-m-d H:i:s");
		}

		// return json_encode([
		// 	'success' => true,
		// 	'data' => $data
		// ]);
		$save = $this->dataModel->insertBatch($data);
		if ($save) {
			$this->session->setFlashdata('sukses', 'Import data berhasil!');
			return json_encode([
				"success" => true,
				'redirect' => '/data'
			]);
		}
		return json_encode([
			"success" => false,
			'msg' => 'Import data gagal!'
		]);
	}

	function tesData()
	{
		$data = $this->dataModel->getData()->getResult();
		dd($data);
	}
}
