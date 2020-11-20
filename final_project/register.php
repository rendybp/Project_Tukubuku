<?php 
    require_once ("assets/koneksi.php");
    session_start();
    if(!empty($_SESSION['id'])){
        header('location: index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Silahkan Daftar</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://repo.rachmat.id/jquery-ui-1.12.1/jquery-ui.css" rel="stylesheet">
    <script type="text/javascript" src="https://repo.rachmat.id/jquery-1.12.4.js"></script>
    <script type="text/javascript" src="https://repo.rachmat.id/jquery-ui-1.12.1/jquery-ui.js"></script>
    <script type="text/javascript">
        $(function(){
        $("#datepicker").datepicker({
            dateFormat:"dd-mm-yy",
        });
        });
</script>
<?php include "assets/preview.php"?>
</head>
<body>
    <div class="kotak_login">
		<p class="tulisan_login">Silahkan Isi Data Berikut</p>
		<form action="#" method="POST" enctype="multipart/form-data">
            <label for="nama">Nama </label>
            <input type="text" name="nama" id="nama" class="form_login" placeholder="Masukkan Namamu" required>
            <label for="email">Email</label>
            <input type="text" name="email" id="email" class="form_login" placeholder="Masukkan Email" required>
            <label>Jenis Kelamin</label>
            <br>
            <input type="radio" name="jenis_kelamin" id="Laki-laki" value="Laki-laki" required> Laki-laki
            <input type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan" required> Perempuan
            <br>
            <div class="ui-widget">
            <label for="tgl_lahir">Tanggal Lahir</label>
            <input type="text" id="datepicker" placeholder="DD-MM-YYYY" name="tgl_lahir" class="form_login" required>
            </div>
			<label for="username">Username</label>
			<input type="text" name="username" id="username" class="form_login" placeholder="Masukkan Username" required>
			<label for="password">Password</label>
			<input type="password" name="password" id="password" class="form_login" placeholder="Masukkan Password" required>
            <label for="konfirmasi_password">Konfirmasi Password</label>
			<input type="password" name="konfirmasi_password" id="konfirmasi" class="form_login" placeholder="Konfirmasi Password" required>
            <label for="gambar">Foto Profil : </label>
            <br>
            <img id="previewImg" src="img/transparent.png" alt="Placeholder">
            <input type="file" name="gambar" onchange="previewFile(this);">
            <?php include "assets/alert_file.php";?>
            <br>
			<input type="submit" class="tombol_login" value="REGISTER" name="submit">
            <br/>
        </form>
        <p class="sudah" style="margin-top:20px; text-align:center">Sudah Punya Akun ? Silahkan <a href="login.php">Login</a></p>
	</div>
    <?php 
        if(isset($_POST['submit'])){
            $nama = $_POST['nama'];
            $email = $_POST['email'];
            $jenkel = $_POST['jenis_kelamin'];
            $tgl_lahir = $_POST['tgl_lahir'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $konfirmasi = $_POST['konfirmasi_password'];
            $lokasi_gambar = "";

            if(empty($_FILES['gambar']['tmp_name'])) {
                if($jenkel == "Laki-laki"){
                    //gambar cowok
                    $lokasi_gambar = "img/user/default_cowok.png";
                } else {
                    //gambar cewek
                    $lokasi_gambar = "img/user/default_cewek.png";
                }
            

                $cek_user = mysqli_query($koneksi,"select username from user where username = '$username'");

                if (mysqli_num_rows($cek_user) == 1) {
                    echo "<script>
                        alert('Username sudah terdaftar silahkan gunakan username lain');
                        document.getElementById('nama').value='$nama';
                        document.getElementById('email').value='$email';
                            if('$jenkel' == 'Laki-laki'){
                                document.getElementById('Laki-laki').checked = true;
                            } else {
                                document.getElementById('perempuan').checked = true;
                            }
                        document.getElementById('datepicker').value='$tgl_lahir';
                        document.getElementById('username').focus();
                    </script>";
                } else {
                    if ($password != $konfirmasi) {
                        echo "<script>alert('Password Tidak Sama, Silahkan Masukkan Lagi');
                        document.getElementById('nama').value='$nama';
                        document.getElementById('email').value='$email';
                            if('$jenkel' == 'Laki-laki'){
                                document.getElementById('Laki-laki').checked = true;
                            } else {
                                document.getElementById('perempuan').checked = true;
                            }
                        document.getElementById('datepicker').value='$tgl_lahir';
                        document.getElementById('username').value='$username';
                        document.getElementById('password').focus();
                        </script>";
                    } else {
                        $options = [
                            'cost' => 10,
                        ];
                        $hashed_password = password_hash($password,PASSWORD_DEFAULT,$options);
                        $queri = "insert into user (nama,email,jenis_kelamin,tanggal_lahir,username,password,gambar) values ('$nama','$email','$jenkel','$tgl_lahir','$username','$hashed_password','$lokasi_gambar')";
                        $tambah = mysqli_query($koneksi,$queri);
                        echo "<script>
                            alert('Data Telah Disimpan silahkan login');
                            window.location.replace('login.php');
                        </script>";
                    }
                }
            } else {
                $cek_user = mysqli_query($koneksi,"select username from user where username = '$username'");

                if (mysqli_num_rows($cek_user) == 1) {
                    echo "<script>
                        alert('Username sudah terdaftar silahkan gunakan username lain');
                        document.getElementById('nama').value='$nama';
                        document.getElementById('email').value='$email';
                            if('$jenkel' == 'Laki-laki'){
                                document.getElementById('Laki-laki').checked = true;
                            } else {
                                document.getElementById('perempuan').checked = true;
                            }
                        document.getElementById('datepicker').value='$tgl_lahir';
                        document.getElementById('username').focus();
                    </script>";
                } else {
                    if ($password != $konfirmasi) {
                        echo "<script>alert('Password Tidak Sama, Silahkan Masukkan Lagi');
                        document.getElementById('nama').value='$nama';
                        document.getElementById('email').value='$email';
                            if('$jenkel' == 'Laki-laki'){
                                document.getElementById('Laki-laki').checked = true;
                            } else {
                                document.getElementById('perempuan').checked = true;
                            }
                        document.getElementById('datepicker').value='$tgl_lahir';
                        document.getElementById('username').value='$username';
                        document.getElementById('password').focus();
                        </script>";
                    } else {
                        // Cek Gambar Sebelum Upload
                        $lokasi = 'img/user/';
                        $nama_gambar = $_FILES['gambar']['name'];
                        $ukuran_gambar	= $_FILES['gambar']['size'];
                        $file_temp = $_FILES['gambar']['tmp_name'];
                        $rand = rand();
                        $ekstensi_boleh	= array('png','jpg','jpeg');
                        $x = explode('.', $nama_gambar);
                        $ekstensi = strtolower(end($x));

                        if (in_array($ekstensi,$ekstensi_boleh)){
                            if ($ukuran_gambar < 1044070) {
                                $lokasi_gambar = $lokasi.$rand.'_'.$nama_gambar;
                                move_uploaded_file($file_temp, $lokasi.$rand.'_'.$nama_gambar);
                                
                                $options = [
                                    'cost' => 10,
                                ];
                                $hashed_password = password_hash($password,PASSWORD_DEFAULT,$options);
                                $queri = "insert into user (nama,email,jenis_kelamin,tanggal_lahir,username,password,gambar) values ('$nama','$email','$jenkel','$tgl_lahir','$username','$hashed_password','$lokasi_gambar')";
                                $tambah = mysqli_query($koneksi,$queri);
                                echo "<script>
                                    alert('Data Telah Disimpan silahkan login');
                                    window.location.replace('login.php');
                                </script>";
                            } else if ($ukuran_gambar > 1044070) {
                                echo "<script>alert('Ukuran File Terlalu besar, pastikan di bawah 1MB');
                                    document.getElementById('nama').value='$nama';
                                    document.getElementById('email').value='$email';
                                    if('$jenkel' == 'Laki-laki'){
                                        document.getElementById('Laki-laki').checked = true;
                                    } else {
                                        document.getElementById('perempuan').checked = true;
                                    }
                                    document.getElementById('datepicker').value='$tgl_lahir';
                                    document.getElementById('username').value='$username';
                                    document.getElementById('password').value='$password';
                                    document.getElementById('konfirmasi').value='$konfirmasi';
                                    </script>";
                            }
                        } else {
                            echo "<script>alert('Ekstensi Wajib jpg / png /jpeg');
                                document.getElementById('nama').value='$nama';
                                document.getElementById('email').value='$email';
                                if('$jenkel' == 'Laki-laki'){
                                    document.getElementById('Laki-laki').checked = true;
                                } else {
                                    document.getElementById('perempuan').checked = true;
                                }
                                document.getElementById('datepicker').value='$tgl_lahir';
                                document.getElementById('username').value='$username';
                                document.getElementById('password').value='$password';
                                document.getElementById('konfirmasi').value='$konfirmasi';
                                </script>";
                        }
                    }
                }
            }
        }
    ?>


</body>
</html>

