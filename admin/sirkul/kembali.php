<?php

if(isset($_GET['kode'])){
    // PERBAIKAN: Tambahkan tgl_dikembalikan=NOW() agar tanggal tercatat saat diklik
    $sql_ubah = "UPDATE tb_sirkulasi SET 
        status='KEM', 
        tgl_dikembalikan=NOW() 
        WHERE id_sk='".$_GET['kode']."'";
    
    $query_ubah = mysqli_query($koneksi, $sql_ubah);

    if ($query_ubah) {
        echo "<script>
        Swal.fire({
            title: 'Kembalikan Buku Berhasil',
            text: '',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'index.php?page=data_sirkul';
            }
        })</script>";
    } else {
        echo "<script>
        Swal.fire({
            title: 'Kembalikan Buku Gagal',
            text: '" . mysqli_error($koneksi) . "', // Menampilkan error jika ada masalah database
            icon: 'error',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'index.php?page=data_sirkul';
            }
        })</script>";
    }
}
?>