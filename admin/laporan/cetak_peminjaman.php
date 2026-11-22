<?php
include "../../inc/koneksi.php";

// 1. Ambil data dari URL (GET) agar error 'Undefined variable' hilang
$tgl_awal = $_GET['tgl_awal'];
$tgl_akhir = $_GET['tgl_akhir'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Cetak Laporan Peminjaman</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; }
        .text-center { text-align: center; }
    </style>
</head>
<body onload="window.print()">
    <center>
        <h3>LAPORAN PEMINJAMAN BUKU</h3>
        <p>Periode: <?= date('d/m/Y', strtotime($tgl_awal)) ?> s/d <?= date('d/m/Y', strtotime($tgl_akhir)) ?></p>
    </center>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama Anggota</th>
                <th>Buku yang Sering Dipinjam</th>
                <th>Total Pinjam</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            // 2. Query untuk mengambil data siswa dan buku yang paling sering mereka pinjam
            $sql = $koneksi->query("SELECT a.nama, a.id_anggota, COUNT(s.id_sk) as total_pinjam,
                (SELECT b.judul_buku 
                 FROM tb_sirkulasi s2 
                 JOIN tb_buku b ON s2.id_buku = b.id_buku 
                 WHERE s2.id_anggota = a.id_anggota 
                   AND s2.tgl_pinjam BETWEEN '$tgl_awal' AND '$tgl_akhir' 
                 GROUP BY s2.id_buku 
                 ORDER BY COUNT(s2.id_buku) DESC 
                 LIMIT 1) as buku_terbanyak
                FROM tb_anggota a 
                JOIN tb_sirkulasi s ON a.id_anggota = s.id_anggota
                WHERE s.tgl_pinjam BETWEEN '$tgl_awal' AND '$tgl_akhir'
                GROUP BY a.id_anggota 
                ORDER BY total_pinjam DESC");

            while ($data = $sql->fetch_assoc()) {
            ?>
                <tr>
                    <td class="text-center"><?= $no++; ?></td>
                    <td><?= $data['id_anggota']; ?></td>
                    <td><?= $data['nama']; ?></td>
                    <td><i><?= $data['buku_terbanyak'] ?? '-'; ?></i></td>
                    <td class="text-center"><?= $data['total_pinjam']; ?> Buku</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div style="float:right; text-align:center; margin-top:50px; width:250px;">
        <p>Mengetahui,</p>
        <p>Kepala Perpustakaan</p>
        <br><br><br>
        <p><b>__________________________</b></p>
    </div>
</body>
</html>