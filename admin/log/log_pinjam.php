<section class="content-header">
    <h1 style="text-align:center;">Riwayat Peminjaman Buku</h1>
    <ol class="breadcrumb">
        <li>
            <a href="index.php">
                <i class="fa fa-home"></i>
                <b>Si Perpustakaan</b>
            </a>
        </li>
    </ol>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-body">
            <form action="?page=hapus_log_pinjam" method="POST">
                
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="10px"><input type="checkbox" id="check-all"></th>
                                <th width="30px">No</th>
                                <th>Buku</th>
                                <th>Peminjam</th>
                                <th>Tgl Peminjaman</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            // Mengambil data dari tabel log_pinjam
                            $sql = $koneksi->query("SELECT l.id_log, b.judul_buku, a.id_anggota, a.nama, l.tgl_pinjam
                                                    FROM log_pinjam l 
                                                    INNER JOIN tb_buku b ON l.id_buku=b.id_buku
                                                    INNER JOIN tb_anggota a ON l.id_anggota=a.id_anggota 
                                                    ORDER BY l.tgl_pinjam DESC");
                            
                            while ($data = $sql->fetch_assoc()) {
                            ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="id_hapus[]" value="<?php echo $data['id_log']; ?>" class="check-item">
                                </td>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $data['judul_buku']; ?></td>
                                <td><?php echo $data['id_anggota']; ?> - <?php echo $data['nama']; ?></td>
                                <td><?php echo date("d/M/Y", strtotime($data['tgl_pinjam'])); ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 10px;">
                    <button type="submit" name="btn_hapus" class="btn btn-danger btn-sm" onclick="return confirm('Hapus riwayat peminjaman yang dipilih?')">
                        <i class="fa fa-trash"></i> Hapus Terpilih
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    // Script Pilih Semua
    document.getElementById('check-all').onclick = function() {
        var checkboxes = document.getElementsByClassName('check-item');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    }
</script>