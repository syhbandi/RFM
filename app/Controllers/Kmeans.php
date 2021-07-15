<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KmeansHistory;
use App\Models\KmeansModel;
use App\Models\RfmModel;

class Kmeans extends BaseController
{
	protected $data = [
		'title' => 'K-Means'
	];

	public function index()
	{
		$kmeansHis = new KmeansHistory();
		$this->data['kmeans_history'] = $kmeansHis->orderBy('tanggal', 'DESC')->findAll();
		return \view('kmeans/view', $this->data);
	}

	public function hitung()
	{
		$data['subtitle'] = 'Hitung';
		return \view('kmeans/hitung', $data);
	}

	public function tesForm()
	{
		$rfmModel = new RfmModel();
		$kmeansModel = new KmeansModel();
		$bulan = $this->request->getVar('bulan');
		$tahun = $this->request->getVar('tahun');
		$arrBulan = [
			'1' => 'Januari',
			'2' => 'Februari',
			'3' => 'Maret',
			'4' => 'April',
			'5' => 'Meil',
			'6' => 'Juni',
			'7' => 'Juli',
			'8' => 'Agustus',
			'9' => 'September',
			'10' => 'Oktober',
			'11' => 'November',
			'12' => 'Desember',
		];
		$periode = $arrBulan[$bulan] . ' ' . $tahun;


		// buat data awal
		$data['awal'] = $rfmModel->getBetween("tgl_aktif BETWEEN '" . $tahun . "-" . $bulan . "-26 00:00:00' 
		AND '" . $tahun . "-" . ($bulan + 1) . "-25 00:00:00'")->getResultArray();
		// \dd($this->request->getVar());
		\dd($data['awal']);
	}

	public function prosesHitung()
	{
		// ambil data inputan
		$bulan = $this->request->getVar('bulan');
		$tahun = $this->request->getVar('tahun');
		$arrBulan = [
			'1' => 'Januari',
			'2' => 'Februari',
			'3' => 'Maret',
			'4' => 'April',
			'5' => 'Meil',
			'6' => 'Juni',
			'7' => 'Juli',
			'8' => 'Agustus',
			'9' => 'September',
			'10' => 'Oktober',
			'11' => 'November',
			'12' => 'Desember',
		];
		$periode = $arrBulan[$bulan] . ' ' . $tahun;


		$rfmModel = new RfmModel();
		$kmeansModel = new KmeansModel();
		// buat data awal
		$data['awal'] = $rfmModel->getBetween("tgl_aktif BETWEEN '" . $tahun . "-" . $bulan . "-26 00:00:00' 
		AND '" . $tahun . "-" . ($bulan + 1) . "-25 00:00:00'")->getResultArray();

		if (\count($data['awal']) <= 0) {
			$this->session->setFlashdata('error', 'Tidak ada data!');
			return \redirect()->to('/kmeans');
		}

		// tentukan cluster
		$m1 = [
			\round($this->request->getVar('c1R'), 3),
			$this->request->getVar('c1F'),
			$this->request->getVar('c1M')
		];
		$m2 = [
			\round($this->request->getVar('c2R'), 3),
			$this->request->getVar('c2F'),
			$this->request->getVar('c2M')
		];

		//simpan cluster di array *maaf lumayan ribet
		$all['centroid']['awal']['m1'] = $m1;
		$all['centroid']['awal']['m2'] = $m2;

		// hitung pengelompokan awal berdasarkan centroid awal
		for ($i = 0; $i < count($data['awal']); $i++) {

			//hitung jarak data dengan masing-masing cluster yang terbentuk 
			$jarakM1 = sqrt(pow(($data['awal'][$i]['r'] - $m1[0]), 2) + pow(($data['awal'][$i]['f'] - $m1[1]), 2) + pow(($data['awal'][$i]['m'] - $m1[2]), 2));
			$jarakM2 = sqrt(pow(($data['awal'][$i]['r'] - $m2[0]), 2) + pow(($data['awal'][$i]['f'] - $m2[1]), 2) + pow(($data['awal'][$i]['m'] - $m2[2]), 2));

			// tentukan cluster data sesuai jarak terdekat dengan cluster
			$cluster = $jarakM1 < $jarakM2 ? 'Cluster 1' : 'Cluster 2';
			$data['awal'][$i]['C1'] = \round($jarakM1, 3);
			$data['awal'][$i]['C2'] = \round($jarakM2, 3);
			$data['awal'][$i]['Cluster'] = $cluster;
		}

		$jumlahCluster1 = 0;
		$sumCluster1R = 0;
		$sumCluster1F = 0;
		$sumCluster1M = 0;

		$jumlahCluster2 = 0;
		$sumCluster2R = 0;
		$sumCluster2F = 0;
		$sumCluster2M = 0;

		for ($k = 0; $k < count($data['awal']); $k++) {
			if ($data['awal'][$k]['Cluster'] == 'Cluster 1') {
				$jumlahCluster1++;
				$sumCluster1R += $data['awal'][$k]['r'];
				$sumCluster1F += $data['awal'][$k]['f'];
				$sumCluster1M += $data['awal'][$k]['m'];
			} else {
				$jumlahCluster2++;
				$sumCluster2R += $data['awal'][$k]['r'];
				$sumCluster2F += $data['awal'][$k]['f'];
				$sumCluster2M += $data['awal'][$k]['m'];
			}
		}

		// cari centroid baru
		$m1 = [round($sumCluster1R / $jumlahCluster1, 3), round($sumCluster1F / $jumlahCluster1, 3), round($sumCluster1M / $jumlahCluster1, 3)];
		$m2 = [round($sumCluster2R / $jumlahCluster2, 3), round($sumCluster2F / $jumlahCluster2, 3), round($sumCluster2M / $jumlahCluster2, 3)];

		//simpan centroid baru utk iterasi selanjutnya
		$all['centroid']['iterasi1']['m1'] = $m1;
		$all['centroid']['iterasi1']['m2'] = $m2;

		// lakukan iterasi utk pengelompokan selanjutnya
		$iterasi = 2;
		for ($i = 1; $i < $iterasi; $i++) {
			$data['iterasi' . $i] = $iterasi == 2 ? $data['awal'] : $data['iterasi' . ($i - 1)];
			$beda = 0;

			// hitung iterasi ke-i
			for ($j = 0; $j < count($data['iterasi' . $i]); $j++) {

				// hitung jarak data dengan centroid
				$jarakM1 = sqrt(pow(($data['iterasi' . $i][$j]['r'] - $m1[0]), 2) + pow(($data['iterasi' . $i][$j]['f'] - $m1[1]), 2) + pow(($data['iterasi' . $i][$j]['m'] - $m1[2]), 2));
				$jarakM2 = sqrt(pow(($data['iterasi' . $i][$j]['r'] - $m2[0]), 2) + pow(($data['iterasi' . $i][$j]['f'] - $m2[1]), 2) + pow(($data['iterasi' . $i][$j]['m'] - $m2[2]), 2));

				// tentukan data masuk ke klaster mana
				$cluster = $jarakM1 < $jarakM2 ? 'Cluster 1' : 'Cluster 2';
				$data['iterasi' . $i][$j]['C1'] = \round($jarakM1, 3);
				$data['iterasi' . $i][$j]['C2'] =  \round($jarakM2, 3);
				$data['iterasi' . $i][$j]['Cluster'] = $cluster;

				// cek hasil cluster sekarang dan sebelumnya --> jika konvergen maka iterasi berhenti
				if ($iterasi == 2) {
					if ($data['awal'][$j]['Cluster'] != $data['iterasi' . $i][$j]['Cluster']) {
						$beda++;
					}
				} else {
					if ($data['iterasi' . ($i - 1)][$j]['Cluster'] != $data['iterasi' . $i][$j]['Cluster']) {
						$beda++;
					}
				}
			}

			$jumlahCluster1 = 0;
			$sumCluster1R = 0;
			$sumCluster1F = 0;
			$sumCluster1M = 0;

			$jumlahCluster2 = 0;
			$sumCluster2R = 0;
			$sumCluster2F = 0;
			$sumCluster2M = 0;

			for ($k = 0; $k < \count($data['iterasi' . $i]); $k++) {
				if ($data['iterasi' . $i][$k]['Cluster'] == 'Cluster 1') {
					$jumlahCluster1++;
					$sumCluster1R += $data['iterasi' . $i][$k]['r'];
					$sumCluster1F += $data['iterasi' . $i][$k]['f'];
					$sumCluster1M += $data['iterasi' . $i][$k]['m'];
				} else {
					$jumlahCluster2++;
					$sumCluster2R += $data['iterasi' . $i][$k]['r'];
					$sumCluster2F += $data['iterasi' . $i][$k]['f'];
					$sumCluster2M += $data['iterasi' . $i][$k]['m'];
				}
			}

			// cari centroid baru
			$m1 = [$sumCluster1R / $jumlahCluster1, $sumCluster1F / $jumlahCluster1, $sumCluster1M / $jumlahCluster1];
			$m2 = [$sumCluster2R / $jumlahCluster2, $sumCluster2F / $jumlahCluster2, $sumCluster2M / $jumlahCluster2];

			$all['centroid']['iterasi' . $iterasi]['m1'] = $m1;
			$all['centroid']['iterasi' . $iterasi]['m2'] = $m2;

			// lanjutkan iterasi jika cluster belum konvergen
			if ($beda > 0) {
				$iterasi++;
			}
		}

		$all['data'] = $data;
		$hasil = \array_pop($data);

		$kmeansHis = new KmeansHistory();
		$kmeansHis->insert([
			'tanggal' => date('Y-m-d H:i:s'),
			'deskripsi' => '-',
			'c1R' => $all['centroid']['awal']['m1'][0],
			'c1F' => $all['centroid']['awal']['m1'][1],
			'c1M' => $all['centroid']['awal']['m1'][2],
			'c2R' => $all['centroid']['awal']['m2'][0],
			'c2F' => $all['centroid']['awal']['m2'][1],
			'c2M' => $all['centroid']['awal']['m2'][2],
			'periode' => $periode,
		]);

		for ($i = 0; $i < count($hasil); $i++) {
			$kmeansModel->save([
				'r' => $hasil[$i]['r'],
				'f' => $hasil[$i]['f'],
				'm' => $hasil[$i]['m'],
				'c1' => $hasil[$i]['C1'],
				'c2' => $hasil[$i]['C2'],
				'cluster' => $hasil[$i]['Cluster'],
				'kmeans_his_id' => $kmeansHis->getInsertID(),
				'rfm_id' => $hasil[$i]['id'],
			]);
		}
		// \dd($hasil);
		return \view('kmeans/hasil', $all);
	}

	public function prosesHitung2()
	{
		$data['iterasi-1'] = [
			[
				'id' => 1,
				'v1' => 1,
				'v2' => 3
			],
			[
				'id' => 2,
				'v1' => 3,
				'v2' => 3
			],
			[
				'id' => 3,
				'v1' => 4,
				'v2' => 3
			],
			[
				'id' => 4,
				'v1' => 5,
				'v2' => 3
			],
			[
				'id' => 5,
				'v1' => 1,
				'v2' => 2
			],
			[
				'id' => 6,
				'v1' => 4,
				'v2' => 2
			],
			[
				'id' => 7,
				'v1' => 1,
				'v2' => 1
			],
			[
				'id' => 8,
				'v1' => 2,
				'v2' => 1
			],
		];

		$m1 = [1, 1];
		$m2 = [2, 1];

		$iterasi = 1;
		for ($i = 0; $i < $iterasi; $i++) {
			$data['iterasi' . $i] = $data['iterasi' . ($i - 1)];

			// hitung iterasi ke-i
			for ($j = 0; $j < count($data['iterasi' . $i]); $j++) {
				$jarakM1 = sqrt(pow(($data['iterasi' . $i][$j]['v1'] - $m1[0]), 2) + pow(($data['iterasi' . $i][$j]['v2'] - $m1[1]), 2));
				$jarakM2 = sqrt(pow(($data['iterasi' . $i][$j]['v1'] - $m2[0]), 2) + pow(($data['iterasi' . $i][$j]['v2'] - $m2[1]), 2));
				$cluster = $jarakM1 < $jarakM2 ? 'Cluster 1' : 'Cluster 2';

				$data['iterasi' . $i][$j]['C1'] = $jarakM1;
				$data['iterasi' . $i][$j]['C2'] = $jarakM2;
				$data['iterasi' . $i][$j]['Cluster'] = $cluster;

				if (isset($data['iterasi' . ($i - 1)][$j]['Cluster']) && $data['iterasi' . ($i - 1)][$j]['Cluster'] == $data['iterasi' . $i][$j]['Cluster']) {
					$iterasi--;
				} else {
					$iterasi++;
				}
			}

			$jumlahCluster1 = 0;
			$sumCluster1V1 = 0;
			$sumCluster1V2 = 0;

			$jumlahCluster2 = 0;
			$sumCluster2V1 = 0;
			$sumCluster2V2 = 0;
			for ($k = 0; $k < \count($data['iterasi' . $i]); $k++) {
				if ($data['iterasi' . $i][$k]['Cluster'] == 'Cluster 1') {
					$jumlahCluster1++;
					$sumCluster1V1 += $data['iterasi' . $i][$k]['v1'];
					$sumCluster1V2 += $data['iterasi' . $i][$k]['v2'];
				} else {
					$jumlahCluster2++;
					$sumCluster2V1 += $data['iterasi' . $i][$k]['v1'];
					$sumCluster2V2 += $data['iterasi' . $i][$k]['v2'];
				}
			}
			$m1 = [$sumCluster1V1 / $jumlahCluster1, $sumCluster1V2 / $jumlahCluster1];
			$m2 = [$sumCluster2V1 / $jumlahCluster2, $sumCluster2V2 / $jumlahCluster2];
		}

		\dd($data);
	}

	public function hasil($id)
	{
		$kmeansModel = new KmeansModel();
		$this->data['kmeans'] = $kmeansModel->getData($id)->getResultArray();
		return \view('kmeans/hasil2', $this->data);
	}
}
