<?php


class Welcome extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_welcome', 'welcome');
	}

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function proses_login()
	{

		$key = $this->config->item('encryption_key');
		$username = $this->input->post('username', TRUE);
		$password = $this->input->post('password', TRUE);

		$salt1 = hash('sha512', $key . $password);
		$salt2 = hash('sha512', $password . $key);
		$salt1_salt2 = hash('sha512', $salt1 . $password . $salt2);
		$hashed_password = md5($salt1_salt2);


		$sql = $this->login->proses_login($username, $hashed_password);
		$cek = $sql->num_rows();
		if ($cek > 0) {
			$dt = $sql->row();
			$data = array(
				'id_akun' => $dt->id,
				'username' => $dt->USERNAME,
				'status' => 'Login'
			);
			$this->session->set_userdata($data);
			$this->session->set_flashdata('alert', ['type' => 'success', 'message' => 'Anda Berhasil Login']);
			redirect('Dashboard');
		} else {
			$this->session->set_flashdata('alert', ['type' => 'error', 'message' => 'Username atau password salah !!']);
			redirect('Login');
		}
	}

	public function logout()
	{
		$this->session->set_flashdata('alert', ['type' => 'success', 'message' => 'Anda Berhasil Logout']);
		session_destroy();
		redirect('Login');
	}
}
