<?php 
require_once ("assets/koneksi.php");
session_start();
$id = $_SESSION['id'];
    if(empty($_SESSION['id'])){
        header('location: logout.php');
    }
$ambil_data = mysqli_query($koneksi,"select * from user where id='$id'");
$data = mysqli_fetch_assoc($ambil_data);
$nama = $data["username"];
?>

<?php 
    include "assets/header.php";
?>

<?php include "assets/link.php"; 
include "assets/user_img.php";
?>

</ul>
</div>

<div class="main">
    <h1 class="salam_main">Data Saya</h1>
    <br>
    <hr>
    <br>
    <div class="dataku cf">
        <div class="foto_profile">
            <img src="<?php echo $data['gambar'];?>" alt="profile">
        </div>
        <div class="datanya">
            <table>
                <tr>
                    <td>Nama </td>
                    <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                    <td><?php echo $data["nama"];?></td>
                </tr>
                <tr>
                    <td>Email </td>
                    <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                    <td><?php echo $data["email"];?></td>
                </tr>
                <tr>
                    <td>Jenis Kelamin </td>
                    <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                    <td><?php echo $data["jenis_kelamin"];?></td>
                </tr>
                <tr>
                    <td>Tanggal Lahir </td>
                    <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                    <td><?php echo $data["tanggal_lahir"];?></td>
                </tr>
                <tr>
                    <td>Username </td>
                    <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                    <td><?php echo $data["username"];?></td>
                </tr>
            </table>
        </div>
        
    </div>
    <div class="tombol_saya">
        <a href="edit.php?id_ubah=<?= $data['id'] ?>" class="tombol satu">Edit</a>
        <a href="ubahpass.php?id_ubah=<?= $data['id'] ?>" class="tombol dua">Ubah Password</a>
    </div>
</div>

<?php 
    include "assets/footer.php"
?>