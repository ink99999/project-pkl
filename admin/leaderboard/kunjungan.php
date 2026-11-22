<?php
// Mengambil tahun saat ini secara otomatis
// Leaderboard akan "ter-reset" otomatis saat tahun berganti karena filter ini
$year = date('Y');

// Query Top 10 Kunjungan berdasarkan tahun berjalan
$sql_top = $koneksi->query("SELECT a.nama, a.id_anggota, COUNT(b.nis) as total 
    FROM tb_anggota a
    JOIN tb_absensi b ON a.id_anggota = b.nis
    WHERE YEAR(b.tgl) = '$year'
    GROUP BY a.id_anggota
    ORDER BY total DESC LIMIT 10");

$rank = 1; 
$data_podium = [];
while($row = $sql_top->fetch_assoc()) { 
    $data_podium[$rank++] = $row; 
}

// Data Grafik Bulanan untuk tahun berjalan
$kunjungan_bulanan = [];
for ($m = 1; $m <= 12; $m++) {
    $res = $koneksi->query("SELECT COUNT(*) as t FROM tb_absensi WHERE MONTH(tgl)='$m' AND YEAR(tgl)='$year'")->fetch_assoc();
    $kunjungan_bulanan[] = $res['t'] ?? 0;
}
$data_json = implode(',', $kunjungan_bulanan);
?>

<style>
    .podium { display: flex; align-items: flex-end; justify-content: center; margin: 20px 0; padding: 20px; background: #fff; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
    .podium-item { text-align: center; margin: 0 10px; width: 140px; }
    .step { color: white; font-weight: bold; font-size: 30px; border-radius: 10px 10px 0 0; display: flex; flex-direction: column; justify-content: flex-end; padding-bottom: 10px; transition: 0.3s; }
    .step-1 { height: 160px; background: #28a745; order: 2; }
    .step-2 { height: 120px; background: #ffc107; order: 1; }
    .step-3 { height: 90px; background: #17a2b8; order: 3; }
    .podium-name { font-size: 14px; font-weight: bold; margin-bottom: 5px; min-height: 20px; color: #333; }
    .podium-points { font-size: 12px; color: #28a745; font-weight: bold; margin-bottom: 5px; }
</style>

<section class="content-header">
    <h1 style="text-align:center;">🏆 Peringkat Kunjungan Terbanyak <br><small><?= $year ?></small></h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-widget">
                <div class="box-body">
                    <div class="podium">
                        <div class="podium-item">
                            <div class="podium-name"><?= $data_podium[2]['nama'] ?? '-' ?></div>
                            <div class="podium-points"><?= $data_podium[2]['total'] ?? 0 ?> Kunjungan</div>
                            <div class="step step-2">2</div>
                        </div>
                        <div class="podium-item">
                            <div class="podium-name"><?= $data_podium[1]['nama'] ?? '-' ?></div>
                            <div class="podium-points"><?= $data_podium[1]['total'] ?? 0 ?> Kunjungan</div>
                            <div class="step step-1">1</div>
                        </div>
                        <div class="podium-item">
                            <div class="podium-name"><?= $data_podium[3]['nama'] ?? '-' ?></div>
                            <div class="podium-points"><?= $data_podium[3]['total'] ?? 0 ?> Kunjungan</div>
                            <div class="step step-3">3</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-line-chart"></i> Statistik Kunjungan Tahunan</h3>
                </div>
                <div class="box-body">
                    <canvas id="chartKunjungan" style="height:250px"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Peringkat 4 - 10</h3>
                </div>
                <div class="box-body no-padding">
                    <table class="table table-striped">
                        <?php for($i=4; $i<=10; $i++) { if(isset($data_podium[$i])) { ?>
                        <tr>
                            <td><?= $i ?>.</td>
                            <td><b><?= $data_podium[$i]['nama'] ?></b></td>
                            <td align="right"><span class="label label-success"><?= $data_podium[$i]['total'] ?> Kali</span></td>
                        </tr>
                        <?php }} ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartKunjungan').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Jumlah Kunjungan',
                data: [<?= $data_json ?>],
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                fill: true, 
                tension: 0.4
            }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false 
        }
    });
</script>