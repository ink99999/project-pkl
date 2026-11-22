<section class="content-header">
    <h1 style="text-align:center;">Laporan Sirkulasi</h1>
    <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-home"></i> <b>Si Perpustakaan</b></a></li>
    </ol>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <a href="?page=MyApp/print_laporan" title="Print" class="btn btn-success">
                <i class="glyphicon glyphicon-print"></i> Print
            </a>
        </div>
        
        <div class="box-body">
            <form action="?page=hapus_sirkulasi" method="POST">
                
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="10px"><input type="checkbox" id="check-all"></th>
                                <th width="30px">No</th>
                                <th>ID SKL</th>
                                <th>Buku</th>
                                <th>Peminjam</th>
                                <th>Tgl Pinjam</th>
                                <th>Jatuh Tempo</th>
                                <th>Tgl Kembali</th>
                                <th>Denda</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = mysqli_query($koneksi, "SELECT s.*, b.judul_buku, a.nama 
                                                      FROM tb_sirkulasi s 
                                                      JOIN tb_anggota a ON a.id_anggota = s.id_anggota 
                                                      JOIN tb_buku b ON b.id_buku = s.id_buku 
                                                      ORDER BY s.id_sk DESC");
                        
                        $no = 0;
                        $total_denda = 0;
                        $tarif_denda = 1000;

                        while ($data = mysqli_fetch_array($sql)) {
                            $no++;

                            if ($data['status'] == 'KEM' && !empty($data['tgl_dikembalikan']) && $data['tgl_dikembalikan'] != '0000-00-00') {
                                $tgl_selesai = new DateTime($data['tgl_dikembalikan']);
                                $tgl_deadline = new DateTime($data['tgl_kembali']);
                                $terlambat = ($tgl_selesai > $tgl_deadline) ? $tgl_deadline->diff($tgl_selesai)->days : 0;
                                $denda = $terlambat * $tarif_denda;
                                $tgl_display = date('d/M/Y', strtotime($data['tgl_dikembalikan']));
                            } else {
                                $denda = 0;
                                $tgl_display = '<span class="label label-warning">Belum Kembali</span>';
                            }
                            $total_denda += $denda;
                        ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="id_hapus[]" value="<?php echo $data['id_sk']; ?>" class="check-item">
                                </td>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $data['id_sk']; ?></td>
                                <td><?php echo $data['judul_buku']; ?></td>
                                <td><?php echo $data['nama']; ?></td>
                                <td><?php echo date('d/M/Y', strtotime($data['tgl_pinjam'])); ?></td>
                                <td><?php echo date('d/M/Y', strtotime($data['tgl_kembali'])); ?></td>
                                <td><?php echo $tgl_display; ?></td>
                                <td>Rp. <?php echo number_format($denda, 0, ',', '.'); ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="8" style="text-align:right;">Total Denda:</th>
                                <th>Rp. <?php echo number_format($total_denda, 0, ',', '.'); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div style="margin-top: 10px;">
                    <button type="submit" name="btn_hapus" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data sirkulasi terpilih?')">
                        <i class="fa fa-trash"></i> Hapus Terpilih
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    document.getElementById('check-all').onclick = function() {
        var checkboxes = document.getElementsByClassName('check-item');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    }
</script>