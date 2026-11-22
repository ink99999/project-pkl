<?php
// Leaderboard otomatis reset setiap tanggal 1 Januari karena menggunakan tahun berjalan
$year = date('Y');

// 1. Query Data Top 10 Peminjam (Siswa Teraktif)
$sql_top = $koneksi->query("SELECT a.nama, a.id_anggota, COUNT(s.id_anggota) as total
    FROM tb_anggota a
    JOIN tb_sirkulasi s ON a.id_anggota = s.id_anggota
    WHERE YEAR(s.tgl_pinjam) = '$year'
    GROUP BY a.id_anggota
    ORDER BY total DESC LIMIT 10");

$rank = 1; 
$data_podium = [];
while($row = $sql_top->fetch_assoc()) { 
    $data_podium[$rank++] = $row; 
}

// 2. Query Tambahan: 5 Buku Paling Banyak Dipinjam Tahun Ini
$sql_buku = $koneksi->query("SELECT b.judul_buku, COUNT(s.id_buku) as jml_pinjam
    FROM tb_buku b
    JOIN tb_sirkulasi s ON b.id_buku = s.id_buku
    WHERE YEAR(s.tgl_pinjam) = '$year'
    GROUP BY b.id_buku
    ORDER BY jml_pinjam DESC LIMIT 5");
?>

<style>
    .podium { display: flex; align-items: flex-end; justify-content: center; margin: 30px 0; padding: 20px; background: #fff; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    .podium-item { text-align: center; margin: 0 15px; width: 140px; }
    .step { color: white; font-weight: bold; font-size: 35px; border-radius: 12px 12px 0 0; display: flex; flex-direction: column; justify-content: flex-end; padding-bottom: 15px; }
    .step-1 { height: 180px; background: #3c8dbc; order: 2; } 
    .step-2 { height: 130px; background: #ffc107; order: 1; }
    .step-3 { height: 100px; background: #17a2b8; order: 3; }
    .podium-name { font-size: 14px; font-weight: bold; margin-bottom: 8px; color: #333; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .podium-points { font-size: 13px; color: #3c8dbc; font-weight: bold; margin-bottom: 8px; background: #f0f7ff; padding: 2px 8px; border-radius: 10px; display: inline-block; }
</style>

<section class="content-header">
    <h1 style="text-align:center;">📚 Peringkat Peminjam Teraktif <br><small><?= $year ?></small></h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-widget">
                <div class="box-body">
                    <div class="podium">
                        <div class="podium-item">
                            <div class="podium-name"><?= $data_podium[2]['nama'] ?? '-' ?></div>
                            <div class="podium-points"><?= $data_podium[2]['total'] ?? 0 ?> Buku</div>
                            <div class="step step-2">2</div>
                        </div>
                        <div class="podium-item">
                            <div class="podium-name"><?= $data_podium[1]['nama'] ?? '-' ?></div>
                            <div class="podium-points"><?= $data_podium[1]['total'] ?? 0 ?> Buku</div>
                            <div class="step step-1">1</div>
                        </div>
                        <div class="podium-item">
                            <div class="podium-name"><?= $data_podium[3]['nama'] ?? '-' ?></div>
                            <div class="podium-points"><?= $data_podium[3]['total'] ?? 0 ?> Buku</div>
                            <div class="step step-3">3</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Daftar Peringkat Peminjam</h3>
                </div>
                <div class="box-body no-padding">
                    <table class="table table-striped">
                        <thead>
                            <tr class="bg-blue">
                                <th width="50px" style="text-align:center">Rank</th>
                                <th>Nama Anggota</th>
                                <th style="text-align:right">Total Pinjam</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data_podium as $r => $d) { ?>
                                <tr>
                                    <td align="center"><?= $r ?></td>
                                    <td><b><?= $d['nama'] ?></b></td>
                                    <td align="right"><?= $d['total'] ?> Buku</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">🔥 5 Buku Terpopuler (<?= $year ?>)</h3>
                </div>
                <div class="box-body no-padding">
                    <table class="table table-striped">
                        <tbody>
                            <?php 
                            $no_buku = 1;
                            while($b = $sql_buku->fetch_assoc()) { ?>
                                <tr>
                                    <td width="30px"><?= $no_buku++ ?>.</td>
                                    <td><?= $b['judul_buku'] ?></td>
                                    <td align="right"><span class="label label-primary"><?= $b['jml_pinjam'] ?> Kali</span></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>