<?php
include 'inc/koneksi.php';
?>
<section class="content-header">
    <h1><i class="fa fa-edit"></i> Buku Tamu Digital <small>Perpustakaan SMPN 2 Ponggok</small></h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="box box-primary" style="border-radius: 15px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
                <div class="box-body text-center" style="padding: 40px 30px;">
                    <img src="dist/img/logo-spmn2ponggok.png" alt="Logo" style="width: 100px; margin-bottom: 20px;">
                    <h3 class="fw-bold" style="margin-top: 0;">Silakan Isi Kehadiran</h3>
                    <p class="text-muted">Masukkan NIS untuk absensi cepat</p>
                    <hr>

                    <?php 
                    if(isset($_GET['status'])) {
                        if($_GET['status'] == 'sukses') {
                            echo '<div class="alert alert-success"><b>Berhasil!</b> Kunjungan Anda telah dicatat.</div>';
                        } elseif($_GET['status'] == 'gagal') {
                            echo '<div class="alert alert-danger"><b>Gagal!</b> NIS tidak ditemukan atau Nama tidak sesuai.</div>';
                        }
                    }
                    ?>

                    <form action="proses_absensi.php" method="POST" autocomplete="off">
                        <div class="form-group">
                            <label style="float: left;">NIS (Nomor Induk Siswa) *</label>
                            <input type="text" name="nis" class="form-control input-lg" 
                                   placeholder="Masukkan NIS Anda" id="nis_input" autofocus required
                                   style="text-align: center; font-size: 24px; font-weight: bold; height: 60px;">
                        </div>

                        <div class="form-group">
                            <label style="float: left;">Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control input-lg" 
                                   placeholder="Masukkan Nama"
                                   style="text-align: center; height: 50px;">
                        </div>

                        <button type="submit" name="simpan" class="btn btn-primary btn-lg btn-block" style="padding: 15px; font-weight: bold;">
                            <i class="fa fa-check-circle"></i> KLIK UNTUK ABSEN
                        </button>
                    </form>
                    
                    <p class="mt-4" style="margin-top: 30px; color: #999;">&copy; 2026 SMPN 2 Ponggok - IT Team</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Autofocus kembali setelah 3 detik jika ada pesan sukses
    setTimeout(() => {
        let inputNis = document.getElementById('nis_input');
        if(inputNis) inputNis.focus();
    }, 3000);
</script>