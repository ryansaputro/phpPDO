# CARA INSTALL DI XAMPP

1. pindahkan project ke dalam folder htdocs.
2. edit file di api/config/config.php.
    - rename base url nya sesuai dengan project yang di simpan di htdocs.
    - edit DB_USER sesuai dengan username anda.
    - edit DB_PASS sesuai dengan password anda.
    - edit DB_NAME sesuai dengan nama database yang anda buat.
3. jalankan command berikut untuk migrasi table
    - cd CLI
    - php transaksi.php migration

4. running aplikasi.


# API
buka aplikasi postman anda
<br /> contoh:
<br />
1. Membuat/Create data Transaksi Pembayaran: http://localhost/development/pribadi/transaksi/create (POST).<br />
    - untuk memberikan value data yang ingin disimpan pilih tab body dan pilih raw.<br />
        contoh: <br />
        ```json
                {
                    "invoice_id": "INV123",
                    "payment_type": "credit_cards",
                    "customer_name": "ryan",
                    "merchant_id": "TRX01",
                    "item": [
                    {
                        "item_name":"sabun",
                        "qty": 4,
                        "price":2000 
                    },
                    {
                        "item_name":"pasta gigi",
                        "qty":3,
                        "price": 200 
                    }]
                }
        ```
    <br/>
2. Mendapatkan/Get status Transaksi Pembayaran: http://localhost/development/pribadi/transaksi/get_status_payment <br/>
    - ```json
        {
            "references_id": "1",
            "merchant_id": "TRX01"
        }
    
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