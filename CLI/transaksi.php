#!/usr/bin/php
<?php

include "M_transaksi.php";

if (1 == $argc) {
    fwrite(STDOUT, "Welcome to Transaksi CLI" . "\n\n");
    writeAvailableCommands();
    return;
}

switch ($argv[1]) {
    case 'cekTransaksi':
        if (!array_key_exists(2, $argv)) {
            fwrite(STDOUT, "mohon masukkan no invoice anda." . "\n");
            writeAvailableCommands();
            return;
        } else {
            $noInvoice = $argv[2];    
            $db = new MTransaksi;
            $data = $db->cekTransaksi($noInvoice);
            foreach($data AS $k => $v){
                fwrite(STDOUT, "INVOICE: ".$v['invoice'] . "\n");
                fwrite(STDOUT, "TANGGAL: ".$v['tanggal'] . "\n");
                fwrite(STDOUT, "TOTAL: ".number_format($v['total']) . "\n");
                fwrite(STDOUT, "STATUS: ".($v['status'] === "0" ? "Pending" : "Paid") . "\n");
            }
        }
    
    break;       
        
    case 'updateTransaksi':
    if (!array_key_exists(2, $argv)) {
        fwrite(STDOUT, "mohon masukkan no invoice anda." . "\n");
        writeAvailableCommands();
        return;
    } else {
        $noInvoice = $argv[2];    
        fwrite(STDOUT, "status:" . "\n");
        fwrite(STDOUT, "0: Pending" . "\n");
        fwrite(STDOUT, "1: Paid" . "\n");
        fwrite(STDOUT, "Masukkan status pembayaran(0/1):" . "\n");
        $status = htmlspecialchars(trim(fgets(STDIN)));

        $jenisStatus = array('1', '0');
        if(!in_array($status, $jenisStatus)){
            fwrite(STDOUT, "status tidak valid" . "\n");
            return;
        }

        $db = new MTransaksi;
        $data = $db->updateTransaksi($noInvoice,$status);
        if($data == '1'){
            fwrite(STDOUT, "sukses update status" . "\n");
            return;
        }else{
            fwrite(STDOUT, "gagal update status" . "\n");
            return;

        }
    }
    break;

    case 'migration';
        fwrite(STDOUT, "mohon tunggu" . "\n");
        $db = new MTransaksi;
        $data = $db->migration();
        fwrite(STDOUT, $data . "\n");
    break;


    default:
        fwrite(STDOUT, "Command not supported!" . "\n");
        writeAvailableCommands();
}

function writeAvailableCommands()
{
    $text = "php transaksi.php";
    fwrite(STDOUT, "Available commads:" . "\n\n");
    fwrite(STDOUT, "$text migration". "\n");
    fwrite(STDOUT, "$text cekTransaksi {no invoice}". "\n");
    fwrite(STDOUT, "$text updateTransaksi {no invoice}". "\n");
}
