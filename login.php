<?php
include "inc/koneksi.php";

if (isset($_POST['btnLogin'])) {  
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, md5($_POST['password']));

    $sql_login = "SELECT * FROM tb_pengguna WHERE BINARY username='$username' AND password='$password'";
    $query_login = mysqli_query($koneksi, $sql_login);
    $data_login = mysqli_fetch_array($query_login, MYSQLI_BOTH);
    $jumlah_login = mysqli_num_rows($query_login);

    if ($jumlah_login == 1) {
        session_start();
        $_SESSION["ses_id"] = $data_login["id_pengguna"];
        $_SESSION["ses_nama"] = $data_login["nama_pengguna"];
        $_SESSION["ses_username"] = $data_login["username"];
        $_SESSION["ses_password"] = $data_login["password"];
        $_SESSION["ses_level"] = $data_login["level"];
        
        $login_status = "sukses";
    } else {
        $login_status = "gagal";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login | SI Perpustakaan</title>
    <link rel="icon" href="dist/img/logo.png">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">

    <style>
        .login-page {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                        url('images/bg-smpn2ponggok.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-box {
            width: 450px; 
            margin: 0;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 25px;
            line-height: 1.2;
        }

        .login-logo .title-top {
            display: block;
            color: #ffffff;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
            font-size: 18px;
            font-weight: 400;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .login-logo .title-bottom {
            display: block;
            color: #ffffff;
            text-shadow: 2px 2px 5px rgba(0,0,0,0.9);
            font-size: 30px;
            font-weight: 900;
            margin-top: 2px;
        }

        @media (max-width: 480px) {
            .login-box { width: 95%; }
            .login-logo .title-top { font-size: 14px; }
            .login-logo .title-bottom { font-size: 22px; }
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#" style="text-decoration: none;">
                <span class="title-top">Sistem Informasi Perpustakaan</span>
                <span class="title-bottom">UPT SMP Negeri 2 Ponggok</span>
            </a>
        </div>
        
        <div class="login-box-body">
            <center>
                <img src="dist/img/logo.png" width="100px" style="margin-bottom: 15px;" />
            </center>
            <p class="login-box-msg" style="font-weight: bold; font-size: 16px;">Silakan Login System</p>
            
            <form action="" method="post">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="username" placeholder="Username" required>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-success btn-block btn-flat" name="btnLogin" style="border-radius: 8px; font-weight: bold; height: 45px; font-size: 16px;">
                            MASUK
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <?php if(isset($login_status)) { ?>
    <script>
        Swal.fire({
            title: '<?php echo ($login_status == "sukses") ? "Login Berhasil" : "Login Gagal"; ?>',
            text: '<?php echo ($login_status == "sukses") ? "Selamat Datang di E-Library" : "Username atau Password salah!"; ?>',
            icon: '<?php echo ($login_status == "sukses") ? "success" : "error"; ?>',
            confirmButtonColor: '#00a65a',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value && '<?php echo $login_status; ?>' === 'sukses') { 
                <?php if($_SESSION["ses_level"] == "Anggota") { ?>
                    // Jika Anggota, arahkan ke halaman absensi
                    window.location = 'index.php?page=absensi'; 
                <?php } else { ?>
                    // Jika Admin/Lainnya, arahkan ke dashboard utama
                    window.location = 'index.php'; 
                <?php } ?>
            }
        });
    </script>
    <?php } ?>
</body>
</html>