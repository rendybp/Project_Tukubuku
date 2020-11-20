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
    <title>Ubah Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="kotak_login">
		<p class="tulisan_login">Ubah Password Untuk User <?php echo $data['username']?></p>
		<form action="#" method="POST">
            <label for="password_lama">Password Lama </label>
            <input type="password" name="password_lama" id="password_lama" class="form_login" placeholder="Masukkan Password Lama" required>
            <label for="pass_baru">Password Baru</label>
            <input type="password" name="pass_baru" id="pass_baru" class="form_login" placeholder="Masukkan Password Baru" required>
            <label for="pass_baru2">Konfirmasi Password Baru</label>
            <input type="password" name="pass_baru2" id="pass_baru2" class="form_login" placeholder="Masukkan Password Baru" required>
            <input type="submit" class="tombol_login" value="EDIT" name="submit">
            <br/>
        </form>
    </div>
    <?php 
        if (isset($_POST['submit'])) {
            $pass_lama = $_POST['password_lama'];
            $pass_baru = $_POST['pass_baru'];
            $konfirm_pass = $_POST['pass_baru2'];

            if (password_verify($pass_lama,$data['password'])) {
                if ($pass_baru == $konfirm_pass) {
                    $options = [
                        'cost' => 10,
                    ];
                    $hashed_password = password_hash($pass_baru,PASSWORD_DEFAULT,$options);
                    $queri_ubah = "UPDATE user SET password='$hashed_password' WHERE id=$id_ubah";
                    $query = mysqli_query($koneksi,$queri_ubah);
                    if( $query ) {
                        echo "<script>
                            alert('Password Telah Diubah');
                            window.location.replace('index.php');
                        </script>";
                    } else {
                        die("Gagal menyimpan perubahan...");
                    }
                } else {
                    echo "<script>alert('Password Tidak sesuai');
                    document.getElementById('password_lama').focus();
                    </script>";
                }
            } else {
                echo "<script>alert('Password Tidak sesuai');
                    document.getElementById('password_lama').focus();
                    </script>";
            }
        }
    ?>
</body>
</html>