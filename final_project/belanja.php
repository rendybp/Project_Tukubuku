<?php
// begin the session
session_start();
require_once ("assets/koneksi.php");
@$id = $_SESSION['id'];
    if(empty($_SESSION['id'])){
        header('location: logout.php');
    }
$ambil_data = mysqli_query($koneksi,"select * from user where id='$id'");
$data = mysqli_fetch_assoc($ambil_data);
@$nama = $data["username"];


$admin = $data["admin"];
    if ($admin != 0) {
        echo "<script>
            alert('Anda Harus Login Sebagai User Untuk Membeli Barang');
            window.location.replace('index.php');
        </script>";
    }

    if (isset($_GET['kode_belanja'])){
    if(isset($_SESSION['keranjang'][$_GET['kode_belanja']])){
        // echo "<script>
        //     alert('Kamu Sudah Membeli Barang Itu, Silahkan Beli Barang Lain');
        //     window.location.replace('index.php');
        // </script>";
        $_SESSION['keranjang'][$_GET['kode_belanja']]++; //jumlah_barang dibeli
    } else {
        $_SESSION['keranjang'][$_GET['kode_belanja']] = 1;
    }
}

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
<div class="main">
<div class="buku">
    
<?php 
    $total = 0;
    
    if (empty($_SESSION['keranjang'])){
        echo "
        <table>
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Kode Buku</th>
                    <th>Judul Buku</th>
                    <th>Pengarang</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan='5' style='text-align: center; padding: 20px;'>Anda Belum Membeli Item</td>
            </tr>
            </tbody>
        </table>
        ";
    } else { ?> 
        <table>
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Kode Buku</th>
                    <th>Judul Buku</th>
                    <th>Pengarang</th>
                    <th>Jumlah</th>
                    <th>Sub Total</th>
                    <th>Hapus Item</th>
                </tr>
            </thead>
            <tbody>
    <?php
        foreach($_SESSION['keranjang'] as $key => $item){
        $query = mysqli_query($koneksi, "select * from buku where kode_buku='$key'");
        $data_buku = mysqli_fetch_array($query);
    ?>
            <tr>
                <td style="text-align: center;"><img src="<?= $data_buku['gambar'];?>" alt="foto" width="100px" ></td>
                <td><?php echo $data_buku["kode_buku"];?></td>
                <td><?php echo $data_buku["judul_buku"];?></td>
                <td><?php echo $data_buku["pengarang"];?></td>
                <td><?php echo $item; 
                $subtotal = $item * $data_buku["harga_buku"];
                
                ?></td>
                <td>Rp. <?php echo $subtotal; $total += $subtotal;?></td>
                <td class="tambahan">
                    <a href="belanja.php?barang_hapus=<?= $data_buku['kode_buku'] ?>" class="tombol dua" onclick="return confirm('Anda yakin mau hapus barang ini ?')">Hapus</a>
                </td>
            </tr>
    <?php 
        }
    }
    ?>
    
    </tbody>
        </table>
    <div class="menu" style="float: right; margin-top: 10px;">
        <a href="#" style="text-decoration: none;">Checkout</a>
    </div>
    <h1 class="total cf" style="margin-right: 20px;">Total Belanja = Rp.<?php echo $total?></h1>

</div>
<br>
<br>
</div>

<?php 
    if (isset($_GET['barang_hapus'])) {
        $barang_hapus = $_GET['barang_hapus'];
        if ($_SESSION['keranjang'][$barang_hapus] > 1){
            $_SESSION['keranjang'][$barang_hapus]--;
        } else {
            unset($_SESSION['keranjang'][$barang_hapus]);
        }
        echo "<script>
            window.location.replace('belanja.php');
        </script>";
    }

    if (!empty($_SESSION['keranjang'])){
        $belanja = serialize($_SESSION['keranjang']);
        $cek_belanja = mysqli_query($koneksi,"select id_pembeli from keranjang where id_pembeli='$id'");
        if (count($_SESSION['keranjang']) > 0) {
            if (mysqli_num_rows($cek_belanja) == 1) {
                $queri_ubah = mysqli_query($koneksi,"update keranjang set belanja='$belanja'");
            } else {
                $queri_tambah = mysqli_query($koneksi,"insert into keranjang (id_pembeli,belanja) values ('$id','$belanja')");
            }
        }
    } else {
        $queri_hapus = mysqli_query($koneksi, "delete from keranjang where id_pembeli='$id'");
    }
    
?>

<?php 
    include "assets/footer.php"
?>