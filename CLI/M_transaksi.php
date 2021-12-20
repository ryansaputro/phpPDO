<?php
require_once '../api/core/Database.php';
require_once '../api/config/config.php';


class MTransaksi{
    private $db;
    private $table = 'transaksi';

    public function __construct()
	{
		$this->db = new Database;
	}


    public function cekTransaksi($noInvoice)
      {
          try {    
            $this->db->query('SELECT * FROM ' . $this->table. ' where invoice=:invoice');
            $this->db->bind('invoice',$noInvoice);
            return $this->db->resultSet();
          }
          catch(PDOException $e)
              {
              echo "Error: " . $e->getMessage();
              }
      }
    public function updateTransaksi($noInvoice, $status)
      {
          try {    
            $query = "UPDATE ". $this->table." SET status=:status where invoice=:invoice";
            $this->db->query($query);
            $this->db->bind('invoice', $noInvoice);
            $this->db->bind('status', $status);
            $this->db->execute();
    
            return $this->db->rowCount();
          }
          catch(PDOException $e)
              {
              echo "Error: " . $e->getMessage();
              }

          return 0;
      }
    
    public function migration(){

      $this->db->getInstance()->beginTransaction();
      try {
        $this->db->query('CREATE TABLE transaction(id int PRIMARY KEY AUTO_INCREMENT,invoice_id varchar(10) NOT NULL UNIQUE, total int(11), payment_type enum("virtual_account", "credit_card"), va varchar(20), customer_name varchar(50), date datetime, status enum("1", "2", "3") COMMENT "1 -> pending, 2-> paid, 3-> failed" DEFAULT "1", merchant_id varchar(10)); CREATE TABLE transaction_detail(id int PRIMARY KEY AUTO_INCREMENT, transaction_id int(11), item_name varchar(50), qty int(11), amount int(11));INSERT INTO transaction (id, invoice_id, total, payment_type, va, customer_name, date, status, merchant_id) VALUES (1, "INV2006015", 8600, "virtual_account", "2092957190", "ryan", "2021-12-20 18:01:53", "1", "TRX01"),
        (2, "INV2006021", 8600, "credit_card", "", "ryan", "2021-12-20 18:02:10", "1", "TRX01");INSERT INTO transaction_detail (id, transaction_id, item_name, qty, amount) VALUES (1, 1, "sabun", 4, 2000), (2, 1, "pasta gigi", 3, 200), (3, 2, "sabun", 4, 2000), (4, 2, "pasta gigi", 3, 200);');
        $this->db->execute();
        $this->db->getInstance()->commit();
        return "migration data has success";
      } catch (\Throwable $th) {
        $this->db->getInstance()->rollBack();
        return "migration data has faild ". $th->getMessage();
      }

      
    }
}
