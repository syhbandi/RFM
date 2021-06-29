<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Data extends BaseController
{
	public function index()
	{
		return \view('data/view');
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
