<?php
// Pastikan tombol hapus ditekan
if (isset($_POST['btn_hapus'])) {
    $id_terpilih = $_POST['id_hapus'];

    if (!empty($id_terpilih)) {
        // Gabungkan ID
        $all_id = implode("','", $id_terpilih);
        
        // Query Hapus
        $sql_hapus = "DELETE FROM log_pinjam WHERE id_log IN ('$all_id')";
        $query_hapus = mysqli_query($koneksi, $sql_hapus);

        if ($query_hapus) {
            // SOLUSI NO 3: Memastikan SweetAlert terpanggil
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                setTimeout(function() {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Riwayat peminjaman telah dihapus',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.value) {
                            // SOLUSI NO 1: Redirect ke nama yang benar
                            window.location = 'index.php?page=log_pinjam';
                        }
                    });
                }, 100);
            </script>";
        } else {
            echo "<script>
                alert('Gagal: " . mysqli_error($koneksi) . "');
                window.history.back();
            </script>";
        }
    } else {
        echo "<script>
            alert('Pilih data terlebih dahulu!');
            window.history.back();
        </script>";
    }
}
?>