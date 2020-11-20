<?php 
    session_start();
    $id = $_SESSION['id'];
    if(empty($_SESSION['id'])){
        header('location: ../logout.php');
    }
    require_once ("koneksi.php");
    if (isset($_GET['kode_hapus'])) {
        $kode_hapus = $_GET['kode_hapus'];

            $hapus = mysqli_query($koneksi, "delete from buku where kode_buku='$kode_hapus'");
            if( $hapus ){
                echo "<script>
                    alert('Data Telah Dihapus');
                    window.location.replace('../index.php');
                </script>";
            } else {
                die("gagal menghapus...");
            }
        
    } else{
        header('location: ../index.php');
    }
?>