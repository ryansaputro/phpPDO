#!/usr/bin/php
<?php

include "M_transaksi.php";

if (1 == $argc) {
    fwrite(STDOUT, "Transaction CLI v1.0" . "\n\n");
    writeAvailableCommands();
    return;
}

switch ($argv[1]) {
    case 'updateTransaksi':
    if (!array_key_exists(2, $argv)) {
        fwrite(STDOUT, "mohon masukkan no invoice anda." . "\n");
        writeAvailableCommands();
        return;
    } else {
        $references_id = $argv[2];    
        $status = $argv[3];    

        $jenisStatus = array('1', '2', '3');
        if(!in_array($status, $jenisStatus)){
            fwrite(STDOUT, "status payment is not valid" . "\n");
            return;
        }

        $db = new MTransaksi;
        $data = $db->updateTransaksi($references_id,$status);
        if($data == '1'){
            fwrite(STDOUT, "updated status payment success" . "\n");
            return;
        }else{
            fwrite(STDOUT, "updated status payment fail" . "\n");
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
    fwrite(STDOUT, "status:" . "\n");
    fwrite(STDOUT, "1: Pending" . "\n");
    fwrite(STDOUT, "2: Paid" . "\n");
    fwrite(STDOUT, "3: Failed" . "\n\n");

    fwrite(STDOUT, "Available commads:" . "\n\n");
    fwrite(STDOUT, "$text migration". "\n");
    fwrite(STDOUT, "$text updateTransaksi {references id} {status}". "\n");
}
