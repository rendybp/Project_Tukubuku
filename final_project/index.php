<?php 
require_once ("assets/koneksi.php");
session_start();
@$id = $_SESSION['id'];
$ambil_data = mysqli_query($koneksi,"select * from user where id='$id'");
$data = mysqli_fetch_assoc($ambil_data);
@$nama = $data["username"];
    $cek_arr = mysqli_query($koneksi,"select id_pembeli from keranjang where id_pembeli='$id'");
    if (mysqli_num_rows($cek_arr) == 1) {
        $ambil_belanja = mysqli_query($koneksi,"select * from keranjang where id_pembeli='$id'");
        $data_belanja = mysqli_fetch_assoc($ambil_belanja);
        $arr_belanja = unserialize($data_belanja['belanja']);
        $_SESSION['keranjang'] = $arr_belanja;
    }
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
<?php 
    $query = mysqli_query($koneksi, "select * from buku where kategori='Fiksi'");
    @$admin = $data["admin"];
    if ($admin == "1") {
        echo "
            <div id='akses_tambah' class='btn-tambah'>
            <a href='tambah_buku.php'>Tambah Buku</a>
            </div>";
    }
?>

<?php while($data_buku = mysqli_fetch_array($query)): ?>
    <div class="kotak_buku cf">
        <img src="<?= $data_buku['gambar']?>" alt="Buku">
        <table>
                <tr>
                    <td>Kode Buku </td>
                    <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                    <td><?php echo $data_buku["kode_buku"];?></td>
                </tr>
                <tr>
                    <td>Judul Buku </td>
                    <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                    <td><?php echo $data_buku["judul_buku"];?></td>
                </tr>
                <tr>
                    <td>Pengarang </td>
                    <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                    <td><?php echo $data_buku["pengarang"];?></td>
                </tr>
                <tr>
                    <td>Harga </td>
                    <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                    <td>Rp. <?php echo $data_buku["harga_buku"];?></td>
                </tr>
            </table>
            <?php 
                @$admin = $data["admin"];
                if ($admin == "1") {
                        echo "
                        <div id='akses_hapus' class='btn-buku'>
                            <a href='assets/hapus_buku.php?kode_hapus="; echo $data_buku['kode_buku']."'"; ?> onclick="return confirm('Anda yakin mau menghapus buku dengan judul <?php echo $data_buku['judul_buku']?> ?')" <?php echo ">Hapus</a>
                        </div>
                        <div id='akses_edit' class='btn-buku'>
                            <a href='edit_buku.php?kode_edit=";echo $data_buku['kode_buku']; echo "'>Edit</a>
                        </div>
                        ";
                } else if ($admin == "0") {
                        echo "<div id='akses_beli' class='btn-buku'>
                            <a href='belanja.php?kode_belanja="; echo $data_buku['kode_buku']; echo "'>Beli</a>
                        </div>
                        ";
                } 
            ?>
    </div>
<?php endwhile; ?>


</div>
<?php 
    include "assets/footer.php"
?>