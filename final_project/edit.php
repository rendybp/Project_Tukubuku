<?php 
    session_start();
    if(empty($_SESSION['id'])){
        header('location: logout.php');
    }

    $id_akses = $_SESSION['id'];

    require_once ("assets/koneksi.php");
    $ambil_akses = mysqli_query($koneksi,"select * from user where id='$id_akses'");
    $akses = mysqli_fetch_assoc($ambil_akses);

    if (isset($_GET['id_ubah'])) {
        $id_ubah = $_GET['id_ubah'];
        $ambil_data = mysqli_query($koneksi,"select * from user where id='$id_ubah'");
        $data = mysqli_fetch_assoc($ambil_data);
    } else{
        header('location: index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data</title>
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
		<p class="tulisan_login">Silahkan Ubah Data Berikut</p>
		<form action="#" method="POST" enctype="multipart/form-data">
            <label for="nama">Nama </label>
            <input type="text" name="nama" id="nama" class="form_login" placeholder="Masukkan Namamu" value="<?php echo $data['nama'] ?>" required>
            <label for="email">Email</label>
            <input type="text" name="email" id="email" class="form_login" placeholder="Masukkan Email" value="<?php echo $data['email'] ?>" required>
            <label>Jenis Kelamin</label>
            <br>
            <?php $jk = $data['jenis_kelamin'];?>
            <input type="radio" name="jenis_kelamin" id="Laki-laki" value="Laki-laki" <?php echo ($jk == 'Laki-laki') ? "checked": "" ?> required> Laki-laki
            <input type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan" <?php echo ($jk == 'Perempuan') ? "checked": "" ?> required> Perempuan
            <br>
            <div class="ui-widget">
            <label for="tgl_lahir">Tanggal Lahir</label>
            <input type="text" id="datepicker" placeholder="DD-MM-YYYY" name="tgl_lahir" class="form_login" value="<?php echo $data['tanggal_lahir'] ?>" required>
            </div>
			<label for="username">Username</label>
            <input type="text" name="username" id="username" class="form_login" placeholder="Masukkan Username" value="<?php echo $data['username'] ?>"  required>
            <label for="gambar">Foto Profil : </label>
            <br>
            <img id="previewImg" src="img/transparent.png" alt="Placeholder">
            <input type="file" name="gambar" onchange="previewFile(this);">
            <?php include "assets/alert_file.php";?>
            <?php 
                $admin = $akses["admin"];
                $hak = $data['admin'];
                if ($admin == 1) {
                    echo "<label for='admin'>Hak Akses </label>
                    <input type='number' name='admin' id='admin' class='form_login' value='$hak' placeholder='1 untuk admin / 0 untuk user' min='0' max='1'>";
                } else {
                    echo "<br>";
                }
            ?>
            <input type="submit" class="tombol_login" value="EDIT" name="submit">
            <br/>
        </form>
	</div>
    <?php 
        if(isset($_POST['submit'])){
            if(isset($_POST['admin'])){
                $nama = $_POST['nama'];
                $email = $_POST['email'];
                $jenkel = $_POST['jenis_kelamin'];
                $tgl_lahir = $_POST['tgl_lahir'];
                $username = $_POST['username'];
                $lokasi_gambar = "";

                if (empty($_POST['admin'])){
                    $admin = $data['admin'];
                } else {
                    $admin = $_POST['admin'];
                }

                if(empty($_FILES['gambar']['tmp_name'])) {

                    if ($username == $data['username']) {
                        $queri_ubah = "UPDATE user SET nama='$nama', email='$email', jenis_kelamin='$jenkel', tanggal_lahir='$tgl_lahir', admin='$admin' WHERE id=$id_ubah";
                        $query = mysqli_query($koneksi,$queri_ubah);
                        if( $query ) {
                            echo "<script>
                                alert('Data Telah Diubah');
                                window.location.replace('index.php');
                            </script>";
                        } else {
                            die("Gagal menyimpan perubahan...");
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
                            $queri_ubah = "UPDATE user SET nama='$nama', email='$email', jenis_kelamin='$jenkel', tanggal_lahir='$tgl_lahir', username='$username', admin='$admin' WHERE id=$id_ubah";
                            $query = mysqli_query($koneksi,$queri_ubah);
                            if( $query ) {
                                echo "<script>
                                    alert('Data Telah Diubah');
                                    window.location.replace('index.php');
                                </script>";
                            } else {
                                die("Gagal menyimpan perubahan...");
                            }
                        }
                    }
                } else {
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
                            if ($username == $data['username']) {
                                $queri_ubah = "UPDATE user SET nama='$nama', email='$email', jenis_kelamin='$jenkel', tanggal_lahir='$tgl_lahir', gambar='$lokasi_gambar', admin='$admin' WHERE id=$id_ubah";
                                $query = mysqli_query($koneksi,$queri_ubah);
                                if( $query ) {
                                    echo "<script>
                                        alert('Data Telah Diubah');
                                        window.location.replace('index.php');
                                    </script>";
                                } else {
                                    die("Gagal menyimpan perubahan...");
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
                                    $queri_ubah = "UPDATE user SET nama='$nama', email='$email', jenis_kelamin='$jenkel', tanggal_lahir='$tgl_lahir', username='$username', gambar='$lokasi_gambar', admin='$admin' WHERE id=$id_ubah";
                                    $query = mysqli_query($koneksi,$queri_ubah);
                                    if( $query ) {
                                        echo "<script>
                                            alert('Data Telah Diubah');
                                            window.location.replace('index.php');
                                        </script>";
                                    } else {
                                        die("Gagal menyimpan perubahan...");
                                    }
                                }
                            }
                            
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

            } else {
                $nama = $_POST['nama'];
                $email = $_POST['email'];
                $jenkel = $_POST['jenis_kelamin'];
                $tgl_lahir = $_POST['tgl_lahir'];
                $username = $_POST['username'];

                if(empty($_FILES['gambar']['tmp_name'])) {

                    if ($username == $data['username']) {
                        $queri_ubah = "UPDATE user SET nama='$nama', email='$email', jenis_kelamin='$jenkel', tanggal_lahir='$tgl_lahir' WHERE id=$id_ubah";
                        $query = mysqli_query($koneksi,$queri_ubah);
                        if( $query ) {
                            echo "<script>
                                alert('Data Telah Diubah');
                                window.location.replace('index.php');
                            </script>";
                        } else {
                            die("Gagal menyimpan perubahan...");
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
                            $queri_ubah = "UPDATE user SET nama='$nama', email='$email', jenis_kelamin='$jenkel', tanggal_lahir='$tgl_lahir', username='$username' WHERE id=$id_ubah";
                            $query = mysqli_query($koneksi,$queri_ubah);
                            if( $query ) {
                                echo "<script>
                                    alert('Data Telah Diubah');
                                    window.location.replace('index.php');
                                </script>";
                            } else {
                                die("Gagal menyimpan perubahan...");
                            }
                        }
                    }
                } else {
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
                            if ($username == $data['username']) {
                                $queri_ubah = "UPDATE user SET nama='$nama', email='$email', jenis_kelamin='$jenkel', tanggal_lahir='$tgl_lahir', gambar='$lokasi_gambar' WHERE id=$id_ubah";
                                $query = mysqli_query($koneksi,$queri_ubah);
                                if( $query ) {
                                    echo "<script>
                                        alert('Data Telah Diubah');
                                        window.location.replace('index.php');
                                    </script>";
                                } else {
                                    die("Gagal menyimpan perubahan...");
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
                                    $queri_ubah = "UPDATE user SET nama='$nama', email='$email', jenis_kelamin='$jenkel', tanggal_lahir='$tgl_lahir', username='$username', gambar='$lokasi_gambar' WHERE id=$id_ubah";
                                    $query = mysqli_query($koneksi,$queri_ubah);
                                    if( $query ) {
                                        echo "<script>
                                            alert('Data Telah Diubah');
                                            window.location.replace('index.php');
                                        </script>";
                                    } else {
                                        die("Gagal menyimpan perubahan...");
                                    }
                                }
                            }
                            
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
    ?>


</body>
</html>