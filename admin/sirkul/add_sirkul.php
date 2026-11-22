<?php
include "inc/koneksi.php";

// Membuat kode sirkulasi otomatis
$carikode = mysqli_query($koneksi,"SELECT id_sk FROM tb_sirkulasi ORDER BY id_sk DESC");
$datakode = mysqli_fetch_array($carikode);

if ($datakode) {
    $kode = $datakode['id_sk'];
    $urut = substr($kode, 1, 3);
    $tambah = (int)$urut + 1;
} else {
    $tambah = 1;
}

$format = "S".sprintf("%03s", $tambah);
?>

<section class="content-header">
	<h1>
		Sirkulasi
		<small>Buku</small>
	</h1>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Tambah Peminjaman</h3>
				</div>

				<form action="" method="post">
					<div class="box-body">

						<div class="form-group">
							<label>Id Sirkulasi</label>
							<input type="text" name="id_sk" class="form-control" value="<?php echo $format; ?>" readonly />
						</div>

						<div class="form-group">
							<label>Nama Peminjam</label>
							<select name="id_anggota" class="form-control" required>
								<option value="">-- Pilih --</option>
								<?php
								$query = mysqli_query($koneksi, "SELECT * FROM tb_anggota");
								while ($row = mysqli_fetch_array($query)) {
								?>
								<option value="<?php echo $row['id_anggota'] ?>">
									<?php echo $row['id_anggota']." - ".$row['nama']; ?>
								</option>
								<?php } ?>
							</select>
						</div>

						<div class="form-group">
							<label>Buku</label>
							<select name="id_buku" class="form-control" required>
								<option value="">-- Pilih --</option>
								<?php
								$query = mysqli_query($koneksi, "SELECT * FROM tb_buku");
								while ($row = mysqli_fetch_array($query)) {
								?>
								<option value="<?php echo $row['id_buku'] ?>">
									<?php echo $row['id_buku']." - ".$row['judul_buku']; ?>
								</option>
								<?php } ?>
							</select>
						</div>

						<div class="form-group">
							<label>Tgl Pinjam</label>
							<input type="date" name="tgl_pinjam" class="form-control" required />
						</div>

					</div>

					<div class="box-footer">
						<input type="submit" name="Simpan" value="Simpan" class="btn btn-info">
						<a href="?page=data_sirkul" class="btn btn-warning">Batal</a>
					</div>
				</form>

			</div>
		</div>
</section>

<?php
if (isset($_POST['Simpan'])){

    $id_sk = $_POST['id_sk'];
    $id_buku = $_POST['id_buku'];
    $id_anggota = $_POST['id_anggota'];
    $tgl_p = $_POST['tgl_pinjam'];

    // tanggal kembali +7 hari
    $tgl_k = date('Y-m-d', strtotime('+7 days', strtotime($tgl_p)));

    // simpan ke tb_sirkulasi
    $sql1 = mysqli_query($koneksi, "INSERT INTO tb_sirkulasi 
    (id_sk,id_buku,id_anggota,tgl_pinjam,tgl_kembali,status)
    VALUES 
    ('$id_sk','$id_buku','$id_anggota','$tgl_p','$tgl_k','PIN')");

    // simpan log pinjam
    $sql2 = mysqli_query($koneksi, "INSERT INTO log_pinjam 
    (id_buku,id_anggota,tgl_pinjam)
    VALUES 
    ('$id_buku','$id_anggota','$tgl_p')");

    if ($sql1 && $sql2){
        echo "<script>
        alert('Tambah Peminjaman Berhasil');
        window.location='index.php?page=data_sirkul';
        </script>";
    } else {
        echo "<script>
        alert('Tambah Peminjaman Gagal');
        window.location='index.php?page=add_sirkul';
        </script>";
    }
}
?>