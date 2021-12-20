<?php

class Transaksi{

	private $table = 'transaction';
	private $db;

	public function __construct()
	{
		$this->db = new Database;
	}

	public function getStatusTransaction($data)
	{
		$rules = array("code" => 400, "data" => null);
		if(empty($data["references_id"])){
			$rules["message"][] =  "please insert references id!";
		}else if($data["references_id"] == ""){
			$rules["message"][] =  "please make sure your references id!";
		}

		if(empty($data["merchant_id"])){
			$rules["message"][] =  "please insert merchant id!";
		}else if($data["merchant_id"] != MERCHANT_ID){
			$rules["message"][] =  "merchant id not found!";
		}

		if(!empty($rules["message"])){
			return json_encode($rules);
			exit;
		}


		$this->db->query('SELECT id, invoice_id, (CASE WHEN status = "1" THEN "Pending" WHEN status = "2" THEN "Paid" ELSE "Failed" END) as status FROM '.$this->table.' WHERE id=:id AND merchant_id=:merchant_id');
		$this->db->bind('id',$data["references_id"]);
		$this->db->bind('merchant_id',$data["merchant_id"]);
		$check = $this->db->single();

		if($check){
			$data['code'] = 200;
			$data['message'] = "succes";
			$data['data'] = $check;
			return json_encode($data);

		}else{
			$data['code'] = 404;
			$data['message'] = "not found";
			$data['data'] = null;
			return json_encode($data);
		}

	}

	public function create($data)
	{
		// validation
		$type_payment = array("virtual_account", "credit_card");
		$rules = array("code" => 400, "data" => null);
		
		if(empty($data["payment_type"])){
			$rules["message"][] = "please choose payment type!";
		}else if($data["payment_type"] == ""){
			$rules["message"][] = "please choose payment type!";
		}else if(!in_array($data["payment_type"], $type_payment)){
			$rules["message"][] = "payment type unknown!";
		}

		if(empty($data["customer_name"])){
			$rules["message"][] =  "please insert your name!";
		}else if($data["customer_name"] == ""){
			$rules["message"][] =  "please insert your name!";
		}

		if(empty($data["item"])){
			$rules["message"][] =  "please choose item to checkout!";
		}else if(count($data["item"]) == 0 ){
			$rules["message"][] =  "please choose item to checkout!";
		}

		if(empty($data["merchant_id"])){
			$rules["message"][] =  "please insert merchant id!";
		}else if($data["merchant_id"] != MERCHANT_ID){
			$rules["message"][] =  "merchant id not found!";
		}


		$sub = 0;
		for($i=0; $i < count($data['item']); $i++){
			$qty = $data['item'][$i]['qty'];
			$harga = $data['item'][$i]['price'];
			
			if((int)$qty <= 0){
				$rules["message"][] =  "please make sure your quantity item more than 1!";
			}
			if((int)$harga <= 0){
				$rules["message"][] =  "please make sure your price item more than 1!";
			}

			$total = (int)$qty*$harga;
			$sub += $total;
			$input[] = [$data['item'][$i]["item_name"], $qty, $harga];

		}

		if(!empty($rules["message"])){
			return json_encode($rules);
			exit;
		}

		$this->db->getInstance()->beginTransaction();
		
		try {
			$va = $data["payment_type"] == "virtual_account" ? rand() : '';

			//code...
			$query = "INSERT INTO ". $this->table." (invoice_id, total, payment_type, va, customer_name, date, status, merchant_id) VALUES(:invoice_id, :total, :payment_type, :va, :customer_name, :date, :status, :merchant_id)";
			$this->db->query($query);
			$this->db->bind('invoice_id', "INV".date('dhis'));
			$this->db->bind('total', (int)$sub);
			$this->db->bind('payment_type', $data["payment_type"]);
			$this->db->bind('va', $va);
			$this->db->bind('customer_name', $data["customer_name"]);
			$this->db->bind('date', date('Y-m-d H:i:s'));
			$this->db->bind('status', '1');
			$this->db->bind('merchant_id', $data["merchant_id"]);
			$this->db->execute();

			$id = $this->db->getInstance()->lastInsertId();

			$sql = "INSERT INTO transaction_detail (item_name, qty, amount, transaction_id) VALUES( ?, ?, ?, ?)";
			$detil = $this->db->getInstance()->prepare($sql);
			foreach($input AS $row){
				$row[3] = $id;		
				$detil->execute($row);
			}
			$this->db->getInstance()->commit();
			$return = array("code" => 200, "message" => "success", "data" => array("references_id" => $id, "number_va" =>$va, "status" => 'Pending'));
			return json_encode($return);

		} catch (\Throwable $th) {
			//throw $th;
			$this->db->getInstance()->rollBack();
			$rules["message"][] =  $th->getMessage();
			return json_encode($rules);
		}

	}

}