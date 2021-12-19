<?php

class TransaksiController extends Controller {
	public function index(){
		$data['title'] = 'List Transaksi';
		$data['code'] = 200;
		$data['message'] = "success";
		$data['data'] = $this->model('Transaksi')->getAllTransaction();

		echo json_encode($data);
	}

	public function detail($id){
		$data['title'] = 'Detail Transaksi';
		$data['code'] = 200;
		$data['message'] = "success";
		$data['data'] = $this->model('Transaksi')->getTransactionById($id);
		
		echo json_encode($data);
	}

	public function create(){	
		$input = json_decode(file_get_contents("php://input"), true);
		
		if( $this->model('Transaksi')->create($input) > 0 ) {
			$data['title'] = 'Transaksi';
			$data['code'] = 200;
			$data['message'] = 'success';
			$data['data'] = null;

			echo json_encode($data);
		}else{
			$data['title'] = 'Transaksi';
			$data['code'] = 500;
			$data['message'] = 'error';
			$data['data'] = null;
			
			echo json_encode($data);
		}
	}

}