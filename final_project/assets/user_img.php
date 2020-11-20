<?php 
        if (empty($_SESSION['keranjang'])){
                $item = 0;
        } else {
                $item = count($_SESSION['keranjang']);
        }
?>

<div class="akses cf" id="login" style="display: none;">
<li><a href="login.php">Login/Daftar</a></li>
</div>


<div class="akun cf" id="user" style="display: none;">
        <li class="uname"><a href="dataku.php"><img src="<?php echo $data['gambar']?>" alt="gambar_user" width="30px"><?php echo $nama?>  |</a></li>
        <li class="lokot"><a href=logout.php onclick="return confirm('Apakah anda yakin ingin logout ?')">Logout</a></li> 
</div>

<div class="link4 akses cf" id="akses_user" style="display: none;">
<div class="belanja">
        <p><?php echo $item;?></p>
</div>
<li><a href="belanja.php">Keranjang Belanja</a></li>
</div>

<div class="link5 akses cf" id="akses_admin" style="display: none;">
<li><a href="data_user.php">Data User</a></li>
</div>

<?php 
        if(empty($_SESSION['id'])){
                echo "<script>
                        document.getElementById('login').style.display = 'block'; 
                </script>";
        } else {
                echo "<script>
                        document.getElementById('user').style.display = 'block'; 
                </script>";
        }

        @$admin = $data["admin"];
        if ($admin == "1") {
                echo "<script>
                        document.getElementById('akses_admin').style.display = 'block'; 
                </script>";
        } else if ($admin == "0") {
                echo "<script>
                        document.getElementById('akses_user').style.display = 'block'; 
                </script>";
        } 
?>

        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script>
        let url = window.location.href;
        let filename = url.split('/').pop();

        if (filename == "index.php" || filename == "index.php#"){
                $(document).ready(function(){
                $('ul div.link1').addClass("active");
                });
        } else if (filename == "nonfiksi.php") {
                $(document).ready(function(){
                $('ul div.link2').addClass("active");
                });
        } else if (filename == "pelajaran.php") {
                $(document).ready(function(){
                $('ul div.link3').addClass("active");
                });
        } else if (filename == "data_user.php") {
                $(document).ready(function(){
                $('ul div.link5').addClass("active");
                });
        } else if (filename == "belanja.php") {
                $(document).ready(function(){
                $('ul div.link4').addClass("active");
                });
        }
        </script>