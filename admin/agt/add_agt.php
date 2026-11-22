<?php
include "inc/koneksi.php";

// Logika kode otomatis dihilangkan dari input, tapi bisa tetap disimpan 
// jika Anda ingin menggunakannya sebagai "saran" di placeholder.
?>

<section class="content-header">
    <h1>
        Master Data
        <small>Data Anggota</small>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Tambah Anggota</h3>
                </div>

                <form action="" method="post">
                    <div class="box-body">

                        <div class="form-group">
                            <label>NIS (ID Anggota)</label>
                            <input type="text" name="id_anggota" class="form-control" placeholder="Masukkan NIS (Contoh: A001)" required>
                        </div>

                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama" class="form-control" placeholder="Nama Anggota" required>
                        </div>

                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="jekel" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas" class="form-control" placeholder="Kelas" required>
                        </div>

                        <div class="form-group">
                            <label>No HP</label>
                            <input type="text" name="no_hp" class="form-control" placeholder="No HP" required>
                        </div>

                    </div>

                    <div class="box-footer">
                        <input type="submit" name="Simpan" value="Simpan" class="btn btn-info">
                        <a href="?page=MyApp/data_agt" class="btn btn-warning">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>

<?php
if (isset($_POST['Simpan'])){

    $id = mysqli_real_escape_string($koneksi, $_POST['id_anggota']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $jekel = $_POST['jekel'];
    $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $nohp = mysqli_real_escape_string($koneksi, $_POST['no_hp']);

    // Validasi Duplikasi: Mengecek apakah ID/NIS sudah ada di database
    $cek_id = mysqli_query($koneksi, "SELECT * FROM tb_anggota WHERE id_anggota='$id'");
    if (mysqli_num_rows($cek_id) > 0) {
        echo "<script>
        alert('Gagal! NIS/ID Anggota sudah digunakan oleh orang lain.');
        window.history.back();
        </script>";
    } else {
        $sql_simpan = mysqli_query($koneksi, "INSERT INTO tb_anggota 
        (id_anggota,nama,jekel,kelas,no_hp) VALUES 
        ('$id','$nama','$jekel','$kelas','$nohp')");

        if ($sql_simpan){
            echo "<script>
            alert('Tambah Data Berhasil');
            window.location='index.php?page=MyApp/data_agt';
            </script>";
        } else {
            echo "<script>
            alert('Tambah Data Gagal');
            window.location='index.php?page=MyApp/add_agt';
            </script>";
        }
    }
}
?>