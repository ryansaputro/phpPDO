# CARA INSTALL DI XAMPP

1. pindahkan project ke dalam folder htdocs.
2. jalankan command berikut untuk migrasi table
    - cd CLI
    - php transaksi.php migration
3. edit file di api/config/config.php.
    - rename base url nya sesuai dengan project yang di simpan di htdocs.
    - edit DB_USER sesuai dengan username anda.
    - edit DB_PASS sesuai dengan password anda.
    - edit DB_NAME sesuai dengan nama database yang anda buat.
4. running aplikasi.


# API
buka aplikasi postman anda
<br /> contoh:
<br />
1. list transaksi: http://localhost/development/pribadi/transaksi (GET).<br />
2. detail transaksi: http://localhost/development/pribadi/transaksi/detail/{id} (GET).<br />
3. create transaksi: http://localhost/development/pribadi/transaksi/create (POST).<br />
        - untuk memberikan value data yang ingin disimpan pilih tab body dan pilih raw.<br />
            contoh membuat data transaksi dengan data lebih dari 1 :<br />
                    [
                        {
                            "id_item":1,
                            "jumlah":1,
                            "harga":2000 
                        },
                        {
                            "id_item":2,
                            "jumlah":3,
                            "harga": 200 
                        }
                    ]
    
# CLI WINDOWS
1. buka cmd anda dan arahkan ke folder project yang telah kita salin.
2. pindah ke folder CLI dengan cara ketik cd CLI
3. running command
    - lihat semua command yang tersedia: php transaksi.php.
    - cek transaksi: php transaksi.php cekTransaksi {no invoice}
    - update status pembayaran: php transaksi.php updateTransaksi {no invoice}


## NOTE
{no invoice}: no invoice yang ingin di cek tanpa tanda {}
    contoh:
            php transaksi.php cekTransaksi INV202112180912