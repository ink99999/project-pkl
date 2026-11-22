<section class="content-header">
    <h1 style="text-align:center;">Laporan Absensi Pengunjung</h1>
    <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-home"></i> <b>Si Perpustakaan</b></a></li>
    </ol>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="fa fa-table"></i> Data Absensi
            </h3>
        </div>
        
        <div class="box-body">
            <form action="?page=hapus_absensi" method="POST">
                
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="10px"><input type="checkbox" id="check-all"></th>
                                <th width="30px">No</th>
                                <th>ID Anggota (NIS)</th>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $sql = $koneksi->query("SELECT * FROM tb_absensi ORDER BY id_absensi DESC");
                            while ($data = $sql->fetch_assoc()) {
                            ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="id_hapus[]" value="<?php echo $data['id_absensi']; ?>" class="check-item">
                                </td>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $data['nis']; ?></td>
                                <td><?php echo $data['nama']; ?></td>
                                <td><?php echo date("d-m-Y", strtotime($data['tgl'])); ?></td>
                                <td><?php echo $data['jam']; ?></td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 10px;">
                    <button type="submit" name="btn_hapus" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data absensi yang dipilih?')">
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