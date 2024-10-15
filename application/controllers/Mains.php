<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mains extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$this->load->view('mains/index.php');
	}
	public function talk(){
		$send = true;
		$key = getenv('TALK_API_KEY');
		$url = 'https://wsapi.simsimi.com/190410/talk';
		$message = json_encode([
			'utext' => $this->input-> post('message',true),
			'lang' => 'en'
		]);
		$header = [
			'Content-type: application/json',
			'x-api-key: ' . $key
		];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,30);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
		curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,TRUE);
		$response = curl_exec($ch);
		$error = '';
		$data = json_decode($response,true);
		if(curl_errno($ch)){
			$error = curl_error($ch);
			$send = false;
		}
		curl_close($ch);
		if($send === true){
			$view_data = array(
				'status' => true,
				'response' => $data['atext']
			);
		}else{
			$view_data = array(
				'status' => true,
				'response' => $error
			);
		}
		header('Content-Type: application/json');
		echo json_encode($view_data);
	}
	// public function sample(){
	// 	$message = array(
	// 		'status' => true,
	// 		'response' => 'I am ok how about you?'
	// 	);
	// 	header('Content-Type: application/json');
	// 	echo json_encode($message,JSON_PRETTY_PRINT);
	// }
}
