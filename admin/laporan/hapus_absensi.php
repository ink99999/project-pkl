<?php
if (isset($_POST['btn_hapus'])) {
    $id_terpilih = $_POST['id_hapus'];
    if (!empty($id_terpilih)) {
        $all_id = implode("','", $id_terpilih);
        $sql = "DELETE FROM tb_absensi WHERE id_absensi IN ('$all_id')";
        
        if (mysqli_query($koneksi, $sql)) {
            echo "<script>window.location='index.php?page=laporan_absensi';</script>";
        }
    }
}
?>