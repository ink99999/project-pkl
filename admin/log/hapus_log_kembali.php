<?php
if (isset($_POST['btn_hapus'])) {
    $id_terpilih = $_POST['id_hapus'];

    if (!empty($id_terpilih)) {
        $all_id = implode("','", $id_terpilih);
        $sql_hapus = "DELETE FROM tb_sirkulasi WHERE id_sk IN ('$all_id')";
        $query_hapus = mysqli_query($koneksi, $sql_hapus);

        if ($query_hapus) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                setTimeout(function() {
                    Swal.fire({
                        title: 'Dihapus!',
                        text: 'Riwayat pengembalian berhasil dibersihkan',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.value) {
                            // Pastikan 'log_kembali' sesuai dengan case di index.php Anda
                            window.location = 'index.php?page=log_kembali';
                        }
                    });
                }, 100);
            </script>";
        }
    } else {
        echo "<script>alert('Pilih data terlebih dahulu!'); window.history.back();</script>";
    }
}
?>