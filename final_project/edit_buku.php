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
    if (isset($_GET['kode_edit'])) {
        $kode_edit = $_GET['kode_edit'];
        $ambil_data = mysqli_query($koneksi,"select * from buku where kode_buku='$kode_edit'");
        $data_buku = mysqli_fetch_assoc($ambil_data);
        $kategori = $data_buku['kategori'];
    } else{
        header('location: index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<?php include "assets/preview.php"?>
    <div class="kotak_login">
		<p class="tulisan_login">Silahkan Isi Data Buku</p>
		<form action="#" method="POST" enctype="multipart/form-data">
            <label for="judul_buku">Judul Buku </label>
            <input type="text" name="judul_buku" id="judul_buku" class="form_login" placeholder="Masukkan Judul Buku" value="<?php echo $data_buku['judul_buku'] ?>" required>
            <label for="gambar">Gambar Sampul : </label>
            <br>
            <img id="previewImg" src="img/transparent.png" alt="Placeholder">
            <input type="file" name="gambar" onchange="previewFile(this);">
            <?php include "assets/alert_file.php";?>
            <label for="pengarang">Pengarang</label>
            <input type="text" name="pengarang" id="pengarang" class="form_login" placeholder="Masukkan pengarang" value="<?php echo $data_buku['pengarang'] ?>" required>
            <br>
			<label for="harga_buku">Harga Buku</label>
            <input type="text" name="harga_buku" id="harga_buku" class="form_login" placeholder="Masukkan Harga Buku" value="<?php echo $data_buku['harga_buku'] ?>" required>
            <select name="kategori" id="kategori" class="form_login">
                <option value="Fiksi" <?php echo ($kategori == 'Fiksi') ? "selected": "" ?>>Fiksi</option>
                <option value="Non-Fiksi" <?php echo ($kategori == 'Non-Fiksi') ? "selected": "" ?>>Non-Fiksi</option>
                <option value="Pelajaran" <?php echo ($kategori == 'Pelajaran') ? "selected": "" ?>>Pelajaran</option>
            </select>
			<input type="submit" class="tombol_login" value="EDIT" name="submit">
            <br/>
        </form>
    </div>

<?php 
    if (isset($_POST['submit'])){
        $judul_buku = $_POST['judul_buku'];
        $pengarang = $_POST['pengarang'];
        $harga_buku = $_POST['harga_buku'];
        $kategori = $_POST['kategori'];
        $lokasi_gambar = "";
        
        

        if(empty($_FILES['gambar']['tmp_name'])) {
            $queri_ubah = "UPDATE buku SET judul_buku='$judul_buku', pengarang='$pengarang', harga_buku='$harga_buku', kategori='$kategori' WHERE kode_buku='$kode_edit'";
            $ubah = mysqli_query($koneksi,$queri_ubah);
                echo "<script>
                        alert('Data Telah Disimpan');
                        window.location.replace('index.php');
                    </script>";
        } else {
            $lokasi = 'img/buku/';
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

                    $queri_ubah = "UPDATE buku SET judul_buku='$judul_buku', pengarang='$pengarang', harga_buku='$harga_buku', kategori='$kategori', gambar='$lokasi_gambar' WHERE kode_buku='$kode_edit'";
                    $ubah = mysqli_query($koneksi,$queri_ubah);
                        echo "<script>
                                alert('Data Telah Disimpan');
                                window.location.replace('index.php');
                            </script>";
                } else if ($ukuran_gambar > 1044070) {
                    echo "<script>alert('Ukuran Gambar Terlalu Besar');
                        document.getElementById('judul_buku').value='$judul_buku';
                        document.getElementById('pengarang').value='$pengarang';
                        document.getElementById('harga_buku').value='$harga_buku';
                        if ('$kategori' == 'Fiksi') {
                            document.getElementById('kategori').selectedIndex = '0';
                        } else if ('$kategori' == 'Non-Fiksi') {
                            document.getElementById('kategori').selectedIndex = '1';
                        } else if ('$kategori' == 'Pelajaran') {
                            document.getElementById('kategori').selectedIndex = '2';
                        }
                        </script>";
                }
            } else {
                echo "<script>alert('Ekstensi Wajib jpg / png /jpeg');
                    document.getElementById('judul_buku').value='$judul_buku';
                    document.getElementById('pengarang').value='$pengarang';
                    document.getElementById('harga_buku').value='$harga_buku';
                    if ('$kategori' == 'Fiksi') {
                        document.getElementById('kategori').selectedIndex = '0';
                    } else if ('$kategori' == 'Non-Fiksi') {
                        document.getElementById('kategori').selectedIndex = '1';
                    } else if ('$kategori' == 'Pelajaran') {
                        document.getElementById('kategori').selectedIndex = '2';
                    }
                    </script>";
            }
        }
    }
?>
</body>
</html>