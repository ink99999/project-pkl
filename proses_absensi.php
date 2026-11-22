<?php
// 1. Koneksi ke Database
include "inc/koneksi.php";

// 2. Cek apakah tombol benar-benar diklik (Gunakan 'simpan' sesuai nama di form)
if (isset($_POST['simpan'])) {
    
    // Ambil input dan bersihkan
    $nis_input = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $nama_input = mysqli_real_escape_string($koneksi, $_POST['nama_siswa']); // Input Nama Opsional
    
    $tgl_sekarang = date("Y-m-d");
    $jam_sekarang = date("H:i:s");

    // 3. Cari di tb_anggota berdasarkan id_anggota
    $sql_cek = mysqli_query($koneksi, "SELECT * FROM tb_anggota WHERE id_anggota='$nis_input'");
    
    if (!$sql_cek) {
        die("Gagal cek database: " . mysqli_error($koneksi));
    }

    $data_cek = mysqli_fetch_array($sql_cek, MYSQLI_BOTH);
    $jumlah_cek = mysqli_num_rows($sql_cek);

    if ($jumlah_cek >= 1) {
        $nama_asli = $data_cek['nama'];

        // LOGIKA VALIDASI: 
        // NIS benar DAN (Nama Kosong ATAU Nama sesuai dengan database)
        if (empty($nama_input) || stripos($nama_asli, $nama_input) !== false) {
            
            // 4. Simpan ke tb_absensi (Kolom: nis, nama, tgl, jam)
            // ERROR SEBELUMNYA: Menggunakan id_anggota yang tidak ada di tb_absensi
            $sql_simpan = mysqli_query($koneksi, "INSERT INTO tb_absensi (nis, nama, tgl, jam) 
                VALUES ('$nis_input', '$nama_asli', '$tgl_sekarang', '$jam_sekarang')");

            if ($sql_simpan) {
                // Redirect balik ke halaman absensi dengan status sukses
                header("location: index.php?page=absensi&status=sukses");
                exit();
            } else {
                echo "Gagal simpan absensi: " . mysqli_error($koneksi);
            }
        } else {
            // Jika Nama diisi tapi tidak cocok dengan pemilik NIS
            header("location: index.php?page=absensi&status=gagal");
            exit();
        }
    } else {
        // Jika NIS tidak terdaftar
        header("location: index.php?page=absensi&status=gagal");
        exit();
    }
} else {
    header("location: index.php");
    exit();
}
?>