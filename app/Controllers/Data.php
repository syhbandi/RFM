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
		$params['draw'] = $_REQUEST['draw'];
		$start = $_REQUEST['start'];
		$length = $_REQUEST['length'];

		$search_value = $_REQUEST['search']['value'];

		if (!empty($search_value)) {
			$total_count = $this->dataModel->search($search_value)->getNumRows();
			$data = $this->dataModel->search($search_value, $start, $length)->getResult();
		} else {
			$total_count = $this->dataModel->get()->getNumRows();
			$data = $this->dataModel->limit($length, $start)->get()->getResult();
		}

		return json_encode([
			"draw" => intval($params['draw']),
			"recordsTotal" => $total_count,
			"recordsFiltered" => $total_count,
			"data" => $data
		]);
	}

	public function save($id = null)
	{
		// return json_encode(['tes' => $this->request->getVar()]);
		// set validation rules
		$rules = [
			'nama' => ['label' => 'Nama', 'rules'  => 'required', 'errors' => ['required' => '{field} harus diisi']],
			'alamat' => ['label' => 'deskripsi', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
			'jumlah_terpasang' => ['label' => 'jumlah terpasang', 'rules'  => 'required', 'errors' => ['required' => '{field} harus diisi']],
			'tgl_daftar' => ['label' => 'tgl. daftar', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
			'tgl_aktif' => ['label' => 'tgl. aktif', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
		];

		// lakukan validasi -> jika gagal kembalikan respon error -> jika berhasil eksekusi code selanjutnya
		if (!$this->validate($rules)) {
			return \json_encode([
				'status' => '500',
				'msg' => $this->validator->getErrors(),
				'tokenCSRF' => csrf_hash(),
			]);
		}

		// return \json_encode($this->request->getVar());

		// simpan data ke db melalui model
		$save = $this->dataModel->save([
			'id' => $id,
			'nama' => $this->request->getPost('nama'),
			'alamat' => $this->request->getPost('alamat'),
			'jumlah_terpasang' => $this->request->getPost('jumlah_terpasang'),
			'keterangan' => $this->request->getPost('keterangan'),
			'tgl_daftar' => $this->request->getPost('tgl_daftar'),
			'tgl_aktif' => $this->request->getPost('tgl_aktif'),
		]);

		// berhasil simpan kembalikan flashdata dan status berhasil
		if ($save) {
			$msg = $id != '' ? 'Data diperbaharui' : 'Data Baru ditambahkan!';
			$this->session->setFlashdata('sukses', $msg);
			return \json_encode([
				'status' => '200',
				'redirect' => '/data'
			]);
		}

		// jika gagal simpan kembalikan error
		return \json_encode([
			'status' => '500',
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

	public function update()
	{
		# code...
	}

	public function delete()
	{
		# code...
	}

	public function exportTemplate()
	{
		$fileName = 'tes.xlsx';
		$spreadsheet = new Spreadsheet();

		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Nama');
		$sheet->setCellValue('B1', 'Alamat');
		$sheet->setCellValue('C1', 'Email');
		$rows = 2;
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

	public function uploadData()
	{

		$file = $this->request->getFile("file");

		$file_name = $file->getTempName();

		$student = array();

		$csv_data = array_map('str_getcsv', file($file_name));

		if (count($csv_data) > 0) {

			$index = 0;

			foreach ($csv_data as $data) {

				if ($index > 0) {

					$student[] = array(
						"name" => $data[1],
						"email" => $data[2],
						"mobile" => $data[3],
						"designation" => $data[4],
					);
				}
				$index++;
			}

			$builder = $this->db->table('tbl_students');

			$builder->insertBatch($student);

			$session = session();

			$session->setFlashdata("success", "Data saved successfully");

			return redirect()->to(base_url('upload-student'));
		}
		return view("upload-file");
	}
}
