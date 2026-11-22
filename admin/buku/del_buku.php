<?php
include "inc/koneksi.php";

if(isset($_GET['kode'])){
    $id_buku = mysqli_real_escape_string($koneksi, $_GET['kode']);

    // Cek apakah buku masih dipakai di sirkulasi
    $cek = mysqli_query($koneksi, "SELECT * FROM tb_sirkulasi WHERE id_buku='$id_buku'");
    $ada = mysqli_num_rows($cek);

    if($ada > 0){
        echo "<script>
        Swal.fire({title: 'Data tidak bisa dihapus',text: 'Buku masih dipakai di sirkulasi',icon: 'warning',confirmButtonText: 'OK'})
        .then((result) => {
            if (result.value) {
                window.location = 'index.php?page=MyApp/data_buku';
            }
        })</script>";
    } else {
        $sql_hapus = mysqli_query($koneksi, "DELETE FROM tb_buku WHERE id_buku='$id_buku'");

        if ($sql_hapus) {
            echo "<script>
            Swal.fire({title: 'Hapus Data Berhasil',icon: 'success',confirmButtonText: 'OK'})
            .then((result) => {
                if (result.value) {
                    window.location = 'index.php?page=MyApp/data_buku';
                }
            })</script>";
        } else {
            echo "<script>
            Swal.fire({title: 'Hapus Data Gagal',icon: 'error',confirmButtonText: 'OK'})
            .then((result) => {
                if (result.value) {
                    window.location = 'index.php?page=MyApp/data_buku';
                }
            })</script>";
        }
    }
}
?>
