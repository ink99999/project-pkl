<?php
include "../../inc/koneksi.php";

// Menangkap periode tanggal dari URL (karena filter pakai GET di link cetak)
$tgl_awal = isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : date('Y-m-01');
$tgl_akhir = isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : date('Y-m-d');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan Kunjungan Siswa</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        .footer { margin-top: 50px; float: right; text-align: center; width: 250px; }
    </style>
</head>
<body onload="window.print()">
    <center>
        <h3>LAPORAN KUNJUNGAN TERBANYAK</h3>
        <p>Periode: <?= date('d/m/Y', strtotime($tgl_awal)) ?> s/d <?= date('d/m/Y', strtotime($tgl_akhir)) ?></p>
    </center>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama Anggota</th>
                <th>Jumlah Kunjungan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            // Query menggunakan BETWEEN agar data keluar sesuai tanggal yang dipilih
            $sql = $koneksi->query("SELECT a.nama, a.id_anggota, COUNT(b.id_absensi) as total 
                FROM tb_anggota a 
                JOIN tb_absensi b ON a.id_anggota = b.nis 
                WHERE b.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' 
                GROUP BY a.id_anggota 
                ORDER BY total DESC");

            while ($data = $sql->fetch_assoc()) {
                echo "<tr>
                    <td>".$no++."</td>
                    <td>".$data['id_anggota']."</td>
                    <td>".$data['nama']."</td>
                    <td>".$data['total']." Kali</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Mengetahui,</p>
        <p>Kepala Perpustakaan</p>
        <br><br><br>
        <p><b>__________________________</b></p>
    </div>
</body>
</html>