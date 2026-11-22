<?php
// Default periode: awal bulan ini sampai hari ini
$tgl_awal = isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : date('Y-m-01');
$tgl_akhir = isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : date('Y-m-d');
?>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Laporan Kunjungan Siswa</h3>
            <div class="box-tools pull-right">
                <form action="" method="post" class="form-inline">
                    <input type="date" name="tgl_awal" class="form-control input-sm" value="<?= $tgl_awal ?>">
                    <span style="margin: 0 5px;">s/d</span>
                    <input type="date" name="tgl_akhir" class="form-control input-sm" value="<?= $tgl_akhir ?>">
                    
                    <button type="submit" name="btnFilter" class="btn btn-sm btn-default">Filter</button>
                    <a href="admin/laporan/cetak_kunjungan.php?tgl_awal=<?= $tgl_awal ?>&tgl_akhir=<?= $tgl_akhir ?>" target="_blank" class="btn btn-sm btn-primary">
                        <i class="fa fa-print"></i> Cetak
                    </a>
                </form>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th><th>NIS</th><th>Nama Anggota</th><th>Jumlah Kunjungan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $sql = $koneksi->query("SELECT a.nama, a.id_anggota, COUNT(b.id_absensi) as total 
                        FROM tb_anggota a 
                        JOIN tb_absensi b ON a.id_anggota = b.nis 
                        WHERE b.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' 
                        GROUP BY a.id_anggota 
                        ORDER BY total DESC LIMIT 10");
                    
                    if (mysqli_num_rows($sql) > 0) {
                        while ($data = $sql->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $data['id_anggota']; ?></td>
                            <td><?= $data['nama']; ?></td>
                            <td><?= $data['total']; ?> Kali</td>
                        </tr>
                        <?php } 
                    } else {
                        echo "<tr><td colspan='4' align='center'>Tidak ada data kunjungan pada periode ini.</td></tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>