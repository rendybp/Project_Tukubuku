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
    <title>Silahkan Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="kotak_login">
		<p class="tulisan_login">Silahkan login</p>
		<form action="#" method="POST">
			<label>Username</label>
			<input type="text" id="username" name="username" class="form_login" placeholder="Masukkan Username" required>
			<label>Password</label>
			<input type="password" id="password" name="password" class="form_login" placeholder="Masukkan Password" required>
			<input type="submit" class="tombol_login" value="LOGIN" name="submit">
			<br/>
        </form>
        <p class="sudah" style="margin-top:20px; text-align:center">Belum Punya Akun ? Silahkan <a href="register.php">Daftar</a></p>
	</div>


    <?php 
        if(isset($_POST['submit'])){
            $username = $_POST['username'];
            $password = $_POST['password'];

            $cek_user = mysqli_query($koneksi,"select * from user where username='$username'");

            if(mysqli_num_rows($cek_user) == 1){
                $data = mysqli_fetch_assoc($cek_user);
                if(password_verify($password,$data["password"])){
                    session_start();
                    $_SESSION['id'] = $data["id"];
                    header('location:index.php');
                }
                else {
                    echo "<script>alert('Password salah');
                    document.getElementById('username').value='$username';
                    document.getElementById('password').focus();
                    </script>";
                }
            } else {
                echo "<script>alert('Username tidak terdaftar')</script>";
            }

            
        }
    ?>
</body>
</html>

