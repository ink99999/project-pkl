<section class="content-header">
    <h1 style="text-align:center;">Riwayat Pengembalian Buku</h1>
    <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-home"></i> <b>Si Perpustakaan</b></a></li>
    </ol>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-body">
            <form action="?page=hapus_log_kembali" method="POST">
                
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="10px"><input type="checkbox" id="check-all"></th>
                                <th width="30px">No</th>
                                <th>Buku</th>
                                <th>Peminjam</th>
                                <th>Tgl Dikembalikan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $sql = $koneksi->query("SELECT s.id_sk, b.judul_buku, a.id_anggota, a.nama, s.tgl_dikembalikan 
                                                  FROM tb_sirkulasi s 
                                                  INNER JOIN tb_buku b ON s.id_buku = b.id_buku
                                                  INNER JOIN tb_anggota a ON s.id_anggota = a.id_anggota 
                                                  WHERE s.status = 'KEM' 
                                                  ORDER BY s.tgl_dikembalikan DESC");

                            while ($data = $sql->fetch_assoc()) {
                            ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="id_hapus[]" value="<?php echo $data['id_sk']; ?>" class="check-item">
                                </td>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $data['judul_buku']; ?></td>
                                <td><?php echo $data['id_anggota']; ?> - <?php echo $data['nama']; ?></td>
                                <td>
                                    <?php 
                                        if (!empty($data['tgl_dikembalikan']) && $data['tgl_dikembalikan'] != '0000-00-00') {
                                            echo date("d/M/Y", strtotime($data['tgl_dikembalikan']));
                                        } else {
                                            echo '<span class="label label-danger">Data Tanggal Kosong</span>';
                                        }
                                    ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 10px;">
                    <button type="submit" name="btn_hapus" class="btn btn-danger btn-sm" onclick="return confirm('Hapus riwayat pengembalian yang dipilih?')">
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