<?php
// ------------------------------------------------------------------------
if (!function_exists('print_query')) {
	/**
	 * PRINT_R HELPER FUNCTION TO PRINT QUERY BEFORE EXECUTING.
	 * PASS $THIS->DB to the PARAM.
	 * debug query
	 */
	function print_query($db)
	{
		echo "<pre>";
		print_r($db->get_compiled_select());
		echo "</pre>";
	}
}
if (!function_exists('number_to_words')) {
	function number_to_words($number)
	{
		$before_comma = trim(to_word($number));
		//$after_comma = trim(comma($number)); //enableit if you wanto use koma
		//return ucwords($results = $before_comma.' koma '.$after_comma);//enableit if you wanto use koma
		return ucwords($results = $before_comma . ' Rupiah ');
	}

	function to_word($number)
	{
		$words = "";
		$arr_number = array(
			"",
			"satu",
			"dua",
			"tiga",
			"empat",
			"lima",
			"enam",
			"tujuh",
			"delapan",
			"sembilan",
			"sepuluh",
			"sebelas"
		);

		if ($number < 12) {
			$words = " " . $arr_number[$number];
		} else if ($number < 20) {
			$words = to_word($number - 10) . " belas";
		} else if ($number < 100) {
			$words = to_word($number / 10) . " puluh " . to_word($number % 10);
		} else if ($number < 200) {
			$words = "seratus " . to_word($number - 100);
		} else if ($number < 1000) {
			$words = to_word($number / 100) . " ratus " . to_word($number % 100);
		} else if ($number < 2000) {
			$words = "seribu " . to_word($number - 1000);
		} else if ($number < 1000000) {
			$words = to_word($number / 1000) . " ribu " . to_word($number % 1000);
		} else if ($number < 1000000000) {
			$words = to_word($number / 1000000) . " juta " . to_word($number % 1000000);
		} else {
			$words = "undefined";
		}
		return $words;
	}

	function comma($number)
	{
		$after_comma = stristr($number, ',');
		$arr_number = array(
			"nol",
			"satu",
			"dua",
			"tiga",
			"empat",
			"lima",
			"enam",
			"tujuh",
			"delapan",
			"sembilan"
		);

		$results = "";
		$length = strlen($after_comma);
		$i = 1;
		while ($i < $length) {
			$get = substr($after_comma, $i, 1);
			$results .= " " . $arr_number[$get];
			$i++;
		}
		return $results;
	}
}
if (!function_exists('auto_format_paragraph')) {
	/**
	 * referensi https://stackoverflow.com/questions/7409512/new-line-to-paragraph-function
	 * @param  [type]  $string      [description]
	 * @param  boolean $line_breaks [description]
	 * @param  boolean $xml         [description]
	 * @return [type]               [description]
	 */
	function auto_format_paragraph($string, $line_breaks = true, $xml = true)
	{

		$string = str_replace(array('<p>', '</p>'), '', $string);

		// It is conceivable that people might still want single line-breaks
		// without breaking into a new paragraph.
		if ($line_breaks == true)
			return '<p>' . preg_replace(array("/([\n]{2,})/i", "/([^>])\n([^<])/i"), array("</p>\n<p>", '$1<br' . ($xml == true ? ' /' : '') . '>$2'), trim($string)) . '</p>';
		else
			return '<p>' . preg_replace(
				array("/([\n]{2,})/i", "/([\r\n]{3,})/i", "/([^>])\n([^<])/i"),
				array("</p>\n<p>", "</p>\n<p>", '$1<br' . ($xml == true ? ' /' : '') . '>$2'),

				trim($string)
			) . '</p>';
	}
}


if (!function_exists('dateToIndo')) {
	/**
	 * [dateToIndo description]
	 * @param  [type]  $date  [description]
	 * @param  boolean $short [description]
	 * @return [type]         [description]
	 */
	function dateToIndo($date, $short = false)
	{
		$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

		$bln_short = array("Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agust", "Sep", "Okt", "Nop", "Des");

		$tahun = substr($date, 0, 4);
		$bulan = substr($date, 5, 2);
		$tgl = substr($date, 8, 2);
		$jam = substr($date, 11, 8);

		if (!$short) {
			$result = $tgl . " " . $BulanIndo[(int) $bulan - 1] . " " . $tahun . " " . $jam;
		} else {
			$result = $tgl . " " . $bln_short[(int) $bulan - 1] . " " . $tahun . " " . $jam;
		}

		return ($result);
	}
}

if (!function_exists('generate_hash')) {
	function generate_hash($name)
	{
		return md5($name) . uniqid() . time();
	}
}

if (!function_exists('set_session')) {
	/**
	 * [dateToIndo description]
	 * @param  boolean $sess [description]
	 * @return void
	 */
	function set_session($sess)
	{
		$ci = &get_instance();

		return $ci->session->userdata($sess);
	}
}

if (!function_exists('get_client_ip')) {
	// Function to get the client IP address.
	function get_client_ip()
	{
		$ipaddress = null;
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if (getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if (getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if (getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if (getenv('HTTP_FORWARDED'))
			$ipaddress = getenv('HTTP_FORWARDED');
		else if (getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = null;
		return $ipaddress;
	}
}

if (!function_exists('pr')) {
	/**
	 * PRINT_R HELPER FUNCTION.
	 */
	function pr($something)
	{
		echo "<pre>";
		print_r($something);
		echo "</pre>";
	}
}

if (!function_exists('get_name_app')) {
	/**
	 * [dateToIndo description]
	 * @param  boolean $sess [description]
	 * @return void
	 */
	function get_name_app($sess)
	{
		$ci = &get_instance();

		return $ci->session->userdata($sess);
	}
}


// Common functions
//------------------------------------------------------------------------------
if (!function_exists('user_agent')) {
	/**
	 * Returns all static user agent data.
	 * @return  array
	 */
	function user_agent()
	{
		static $result = null;
		if (!is_array($result)) {
			$ci = get_instance();
			$ci->load->library('user_agent');
			$agent = $ci->agent;
			$result['agent_string'] = $agent->agent_string();
			$result['platform'] = $agent->platform();
			$result['browser'] = $agent->browser();
			$result['version'] = $agent->version();
			$result['robot'] = $agent->robot();
			$result['mobile'] = $agent->mobile();
			$result['referrer'] = $agent->referrer();
			$result['is_referral'] = $agent->is_referral();
			$result['languages'] = $agent->languages();
			$result['charsets'] = $agent->charsets();
		}
		return $result;
	}
}

if (!function_exists('random_color_part')) {
	/**
	 * Returns all static user agent data.
	 * @return  array
	 */
	function random_color_part()
	{
		return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
	}
}

if (!function_exists('random_color')) {
	/**
	 * Returns all static user agent data.
	 * @return  array
	 */
	function random_color()
	{
		return random_color_part() . random_color_part() . random_color_part();
	}
}

if (!function_exists('get_router_active')) {
	/**
	 * Returns all static user agent data.
	 * @return  array
	 */
	function get_router_active()
	{
		$CI = &get_instance();

		$get_data = $CI->Global_model->set_model('tbl_router', 'tr', 'id')->mode(array(
			'type' => GET_ALL_DATA,
			'conditions' => array(
				'is_active' => ACTIVE
			)
		));

		return $get_data;
	}
}

// if (!function_exists('sql_injection')) {
// 	/**
// 	 * Function to sanitize form input, ajax input, or else.
// 	 * used mainly for string input, at default will replace anything except:
// 	 * a-z A-Z 0-9 - _ . , space / ~ : @ ? ( )'
// 	 * become empty string ""
// 	 * TYPE :
// 	 * numeric, string, date, daterange, array, [1 => val, 2 => val, 3 => val], "1,2",
// 	 */
// 	function sql_injection($str = NULL, $type = "string", $regex = "/[^a-zA-Z0-9\/~\-_.():@,?\'\s]+/")
// 	{
// 		switch ($type) {
// 			case 'string':
// 				$str = trim($str);
// 				return preg_replace($regex, "", $str);
// 				break;

// 			case 'numeric':
// 				if (is_numeric($str) === FALSE) return null;
// 				return $str;
// 				break;

// 			case 'date':
// 				return validate_date_input($str);
// 				break;

// 			case 'array':
// 				if (is_array($str) === FALSE) return null;
// 				return $str;
// 				break;

// 			default:
// 				if (is_array($type)) {
// 					if (array_key_exists($str, $type)) {
// 						return $str;
// 					} else {
// 						return null;
// 					}
// 				} else if (count(explode(",", $type)) > 0) {
// 					$data = explode(",", $type);
// 					if (array_search($str, $data) === FALSE) {
// 						return null;
// 					} else {
// 						return $str;
// 					}
// 				}
// 				break;
// 		}
// 		return preg_replace($regex, "", $str);
// 	}
// }

//option dropdown dinamis
//add edit
function select_unit_Kategori($name, $selected = FALSE, $html_attr = '', $add_options = array("" => " -- Pilih --"))
{
	$ci = &get_instance();
	$ci->load->helper('form');
	$ci->load->model('M_sppr_kategori');
	$datas = $ci->M_sppr_kategori->get_unit_cat();

	if (!$datas) :
		return FALSE;
	endif;
	$datas = array_column($datas, "UNIT", "ID");
	return form_dropdown($name, $add_options + $datas, $selected, $html_attr);
}


function hitung_masa_kerja_aktif($tgl_msuk)
{
	$tgl_msuk = str_replace('/', '-', $tgl_msuk);
	$date_1 = date("Y-m-d", strtotime($tgl_msuk));
	// print_r($date_1);die();
	$date_2 = date('Y-m-d');

	$awal  = new DateTime($date_1);
	$akhir = new DateTime(); // Waktu sekarang
	$diff  = $awal->diff($akhir);

	if ($diff->format('%Y') == 00) {
		$total = $diff->format('%m bulan %d hari');
	} else {
		$total = $diff->format('%Y tahun %m bulan %d hari');
	}

	return $total;
}
function hitung_masa_kerja_resign($tgl_msuk, $tgL_Keluar)
{
	$tgl_msuk = str_replace('/', '-', $tgl_msuk);
	$date_1 = date("Y-m-d", strtotime($tgl_msuk));
	// print_r($date_1);die();
	$tgL_Keluar = str_replace('/', '-', $tgL_Keluar);
	$date_2 = date("Y-m-d", strtotime($tgL_Keluar));

	$awal2  = new DateTime($date_1);
	$akhir2 = new DateTime($date_2); // Waktu sekarang
	$diff2  = $awal2->diff($akhir2);

	if ($diff2->format('%Y') == 00) {
		$total2 = $diff2->format('%m bulan %d hari');
	} else {
		$total2 = $diff2->format('%Y tahun %m bulan %d hari');
	}

	return $total2;
}
