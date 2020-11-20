<?php 
require_once ("assets/koneksi.php");
session_start();
// @$id_pembeli = $_SESSION['id'];
// $belanja = serialize($_SESSION['keranjang']);
// $cek_belanja = mysqli_query($koneksi,"select id_pembeli from keranjang where id_pembeli='$id_pembeli'");
// if (count($_SESSION['keranjang']) > 0) {
//     if (mysqli_num_rows($cek_belanja) == 1) {
//         $queri_ubah = mysqli_query($koneksi,"update keranjang set belanja='$belanja'");
//     } else {
//         $queri_tambah = mysqli_query($koneksi,"insert into keranjang (id_pembeli,belanja) values ('$id_pembeli','$belanja')");
//     }
// } else {
//     $queri_hapus = mysqli_query($koneksi, "delete from keranjang where id_pembeli='$id_pembeli'");
// }

session_destroy();
header('location: index.php');
?>