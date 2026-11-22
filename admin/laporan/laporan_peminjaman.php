<?php
$tgl_awal = isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : date('Y-m-01');
$tgl_akhir = isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : date('Y-m-d');
?>

<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Laporan Peminjaman Buku</h3>
            <div class="box-tools pull-right">
                <form action="" method="post" class="form-inline">
                    <input type="date" name="tgl_awal" class="form-control input-sm" value="<?= $tgl_awal ?>">
                    <span style="margin: 0 5px;">s/d</span>
                    <input type="date" name="tgl_akhir" class="form-control input-sm" value="<?= $tgl_akhir ?>">
                    
                    <button type="submit" name="btnFilter" class="btn btn-sm btn-default">Filter</button>
                    <a href="admin/laporan/cetak_peminjaman.php?tgl_awal=<?= $tgl_awal ?>&tgl_akhir=<?= $tgl_akhir ?>" target="_blank" class="btn btn-sm btn-success">
                        <i class="fa fa-print"></i> Cetak
                    </a>
                </form>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama Anggota</th>
                        <th>Buku Sering Dipinjam</th> <th>Total Pinjam</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    // Logika Subquery: Mencari 1 judul buku dengan jumlah peminjaman terbanyak KHUSUS untuk siswa tersebut
                    $sql = $koneksi->query("SELECT a.nama, a.id_anggota, COUNT(s.id_sk) as total,
                        (SELECT b.judul_buku FROM tb_sirkulasi s2 
                         JOIN tb_buku b ON s2.id_buku = b.id_buku 
                         WHERE s2.id_anggota = a.id_anggota AND s2.tgl_pinjam BETWEEN '$tgl_awal' AND '$tgl_akhir' 
                         GROUP BY s2.id_buku 
                         ORDER BY COUNT(s2.id_buku) DESC LIMIT 1) as buku_terbanyak_siswa
                        FROM tb_anggota a 
                        JOIN tb_sirkulasi s ON a.id_anggota = s.id_anggota
                        WHERE s.tgl_pinjam BETWEEN '$tgl_awal' AND '$tgl_akhir'
                        GROUP BY a.id_anggota ORDER BY total DESC LIMIT 10");
                    
                    if (mysqli_num_rows($sql) > 0) {
                        while ($data = $sql->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $data['id_anggota'] ?></td>
                                <td><?= $data['nama'] ?></td>
                                <td><i><?= $data['buku_terbanyak_siswa'] ?? '-' ?></i></td> 
                                <td><?= $data['total'] ?> Buku</td>
                            </tr>
                        <?php }
                    } else {
                        echo "<tr><td colspan='5' align='center'>Tidak ada data peminjaman pada periode ini.</td></tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>