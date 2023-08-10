<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_model extends CI_Model
{
 private $dblogin;
	public function __construct()
	{
		parent::__construct();
			$this->dblogin = $this->load->database('dblogins', TRUE);
	}

	/** 
	 * check login
	 * @param string $user
	 *        int    $pass
	 * @return array 
	 */
	public function check_login($u, $p)
	{
		$this->load->library('user_agent');

		// $username = substr($u, 0, -2);
		$password = sha1($p);
		$this->dblogin->select('a.*,b.NIK as NIKKaryawan,b.Nama,b.DEPT_NAME,b.JABATAN,c.APP_OWNER,c.APP_ID');
		$this->dblogin->from('db_logins.tb_logins a');
		$this->dblogin->join('dbabsensi.hr_staff_info b', 'a.NIK = b.NIK', 'left');
		$this->dblogin->join('db_logins.tb_app_level c', 'a.ID = c.USER_ID', 'left');
		$this->dblogin->where('a.USER_NAME', $u);
		$this->dblogin->where('a.PASSWORDS', $password);
		$this->dblogin->where('a.STATUS', 1);
		// $this->dblogin->where('a.PENGURUS_KOPERASI', 1);

		$result = $this->dblogin->get();
		if ($result->num_rows() > 0) {
			return $result->row();
		}
		return false;
	}
	public function get_by_id($id)
	{
		$this->dblogin->select("*");
		$this->dblogin->from('db_logins.tb_logins');
		$this->dblogin->where('USER_NAME', $id);
		$query = $this->dblogin->get();

		return $query->row();
	}
}