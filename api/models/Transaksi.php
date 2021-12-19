<?php

class Transaksi{

	private $table = 'transaksi';
	private $db;

	public function __construct()
	{
		$this->db = new Database;
	}

	public function getAllTransaction()
	{
		$this->db->query('SELECT * FROM ' . $this->table);
		return $this->db->resultSet();
	}

	public function getTransactionById($id)
	{
		$this->db->query('SELECT * FROM transaksi_detail WHERE id_transaksi=:id');
		$this->db->bind('id',$id, PDO::PARAM_INT);
		return $this->db->resultSet();
	}

	public function create($data)
	{
		$sub = 0;
		for($i=0; $i < count($data); $i++){
			$qty = $data[$i]['jumlah'];
			$harga = $data[$i]['harga'];
			
			if(!is_numeric($qty) || !is_numeric($harga)){
				return 0;
			}

			$total = (int)$qty*$harga;
			$sub += $total;
			$input[] = [$data[$i]["id_item"], $qty, $harga];

		}
			$this->db->getInstance()->beginTransaction();
			
			try {

				//code...
				$query = "INSERT INTO ". $this->table." (invoice, tanggal, total, status) VALUES(:invoice, :tanggal, :total, :status)";
				$this->db->query($query);
				$this->db->bind('invoice', "INV".date('YmdHs'));
				$this->db->bind('tanggal', date('Y-m-d H:i:s'));
				$this->db->bind('total', (int)$sub);
				$this->db->bind('status', '0');
				$this->db->execute();

				$id = $this->db->getInstance()->lastInsertId();

				$sql = "INSERT INTO transaksi_detail (id_item, jumlah, harga, id_transaksi) VALUES( ?, ?, ?, ?)";
				$detil = $this->db->getInstance()->prepare($sql);
				foreach($input AS $row){
					$row[3] = $id;		
					$detil->execute($row);
				}
				$this->db->getInstance()->commit();
				return $this->db->rowCount();
			} catch (\Throwable $th) {
				//throw $th;
				$this->db->getInstance()->rollBack();
				return 0;
			}

	}

}