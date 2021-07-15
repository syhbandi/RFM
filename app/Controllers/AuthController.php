<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AuthModel;

class AuthController extends BaseController
{
	public function index()
	{
		if ($this->session->logged_in) {
			return \redirect()->to('/home');
		}
		return \view('login');
	}

	public function login()
	{
		$where = [
			'email' => $this->request->getVar('email'),
			'password' => \md5($this->request->getVar('password'))
		];

		$userModel = new AuthModel();
		$data = $userModel->where($where)->first();

		if ($data != null) {
			$sessionData = [
				'id' => $data['id'],
				'nama' => $data['nama'],
				'email' => $data['email'],
				'akses_level' => $data['akses_level'],
				'logged_in' => TRUE,
			];
			$this->session->set($sessionData);

			return \json_encode([
				'success' => true,
				'redirect' => '/home',
				'data' => $data
			]);
		}

		return \json_encode([
			'success' => false,
			'msg' => 'Email atau Password salah',
			'redirect' => '/home',
			'data' => $data
		]);
	}

	public function logout()
	{
		$this->session->destroy();
		return \redirect()->to('/login');
	}
}
