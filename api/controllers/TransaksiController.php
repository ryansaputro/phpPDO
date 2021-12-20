<?php

class TransaksiController extends Controller {

	public function get_status_payment(){
		$input = json_decode(file_get_contents("php://input"), true);
		$data['title'] = 'Payment Status';
		$check = $this->model('Transaksi')->getStatusTransaction($input);
		$check = json_decode($check);
		
		$data['code'] = $check->code;
		$data['message'] = $check->message;
		$data['data'] = $check->data;

		echo json_encode($data);
	}

	public function create(){	
		$input = json_decode(file_get_contents("php://input"), true);
		$insert = $this->model('Transaksi')->create($input);
		$insert = json_decode($insert);

		$data['title'] = 'Transaksi';
		$data['code'] = $insert->code;
		$data['message'] = $insert->message;
		$data['data'] = $insert->data;

		echo json_encode($data);
	}

}