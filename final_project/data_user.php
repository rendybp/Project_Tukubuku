<?php 
require_once ("assets/koneksi.php");
session_start();
$id = $_SESSION['id'];
    if(empty($_SESSION['id'])){
        header('location: logout.php');
    }

$ambil_data = mysqli_query($koneksi,"select * from user where id='$id'");
$data = mysqli_fetch_assoc($ambil_data);
$admin = $data["admin"];
    if ($admin == 0) {
        echo "<script>
            alert('Halaman itu hanya bisa diakses oleh admin, silahkan login sebagai admin');
            window.location.replace('index.php');
        </script>";
    }
$nama = $data["username"];
?>

<?php 
    include "assets/header.php";
?>
<link rel="stylesheet" href="style_table.css">
<?php include "assets/link.php"; 
include "assets/user_img.php";
?>

</ul>
</div>

<?php 
    $query = mysqli_query($koneksi, "select * from user");
?>

<div class="main">
<h1 class="salam_main">Data User</h1>
    <br>
    <hr>
<div class="user">
<h3 class="cf" style="font-size: 20px; float:right;"><a href="tambah.php" style="text-decoration:none;">Tambah Data</a></h3>
<h3 style="font-size: 20px;">&nbsp;Total: <?php echo mysqli_num_rows($query) ?></h3>
<table>
	<thead>
		<tr>
            <th>No</th>
            <th>Foto</th>
			<th>Nama</th>
			<th>Email</th>
			<th>Jenis Kelamin</th>
			<th>Tanggal Lahir</th>
            <th>Username</th>
            <th>Hak Akses</th>
            <th>Tindakan</th>
		</tr>
	</thead>
	<tbody>
        <?php
        
        $no = 1;
		
		while($data_user = mysqli_fetch_array($query)): ?>
			<tr>
            <td><?php echo $no?></td>
            <td><img src="<?= $data_user['gambar'];?>" alt="foto" width="100px"></td>
			<td><?= $data_user['nama']?></td>
			<td><?= $data_user['email']?></td>
			<td><?= $data_user['jenis_kelamin']?></td>
			<td><?= $data_user['tanggal_lahir']?></td>
			<td><?= $data_user['username']?></td>
            
            <?php 
                if ($data_user['admin'] == 1) {
                    $akses = "Admin";
                } else if ($data_user['admin'] == 0){
                    $akses = "User";
                }
            ?>

            <td><?php echo $akses?></td>

            <td class="tambahan">
			<a href="edit.php?id_ubah=<?= $data_user['id'] ?>" class="tombol satu">Edit</a>
			<a href="assets/hapus.php?id_hapus=<?= $data_user['id'] ?>" class="tombol dua" onclick="return confirm('Anda yakin mau menghapus data dengan username <?php echo $data_user['username']?> ?')">Hapus</a>
            </td>
			
            </tr>
		<?php $no++; endwhile; ?>
		
	</tbody>
    </table>
</div>
</div>

<?php 
    include "assets/footer.php"
?>