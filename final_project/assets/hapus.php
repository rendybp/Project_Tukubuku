<?php 
    session_start();
    $id = $_SESSION['id'];
    if(empty($_SESSION['id'])){
        header('location: ../logout.php');
    }
    require_once ("koneksi.php");
    if (isset($_GET['id_hapus'])) {
        $id_hapus = $_GET['id_hapus'];
        if ($id_hapus == $id) {
            $hapus = mysqli_query($koneksi, "delete from user where id=$id_hapus");
            if( $hapus ){
                echo "<script>
                    alert('Data Telah Dihapus');
                    window.location.replace('../logout.php');
                </script>";
            } else {
                die("gagal menghapus...");
            }
        } else {
            $hapus = mysqli_query($koneksi, "delete from user where id=$id_hapus");
            if( $hapus ){
                echo "<script>
                    alert('Data Telah Dihapus');
                    window.location.replace('../data_user.php');
                </script>";
            } else {
                die("gagal menghapus...");
            }
        }
    } else{
        header('location: ../index.php');
    }
?>