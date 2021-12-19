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
          //establish database connection
    
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
}
