<?php
require 'controller/crudController.php';
require 'controller/sessionController.php';
checkLoginSession(); //MENGECEK SESSION, FUNCTION ADA PADA FOLDER SESSIONCONTROLLER
if (isset($_POST["login"])) { //JIKA TOMBOL SUBMIT YANG BERNAMA LOGIN DITEKAN, MAKA AKAN MENJALANKAN FUNGSI LOGIN
    login($_POST); //PASSING DATA $_POST KE FUNGSI LOGIN
}
if (isset($_POST["register"])) {  //JIKA TOMBOL SUBMIT YANG BERNAMA REGISTER DITEKAN, MAKA AKAN MENJALANKAN FUNGSI REGISTER
    if (register($_POST) > 0) { //PASSING DATA KE FUNGSI REGISTER
        echo "<script>
        alert('berhasil');
        window.location = 'index.php'
        </script>"; //JIKA REGISTER BERHASIL, MAKA MUNCUL ALERT
    }else {
        echo mysqli_error($koneksi);
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- My CSS -->
    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>
</head>
<body>

<!-- form -->
	<div id="kotaklogin" style="margin-top: 2rem;">
    
    <!-- KIRI -->
        <div class="row">   
            <div class="column" style="background-color: #a70000;height: 600px;">
            <div class="logintitlewrapper">
                <h1 class="logintitle">Sistem Manajemen Sekolah</h1>
                <h1 class="logintitle">SMK Negeri 2 Singosari</h1>
            </div>
        </div>

    <!-- KANAN -->
    <!-- LOGIN -->
            <div class="column" id="login" style="margin-top: 8rem; padding: 0 40px 0 40px; display: block;">
            <h3 style="text-align: center;"><b>Login</b></h3>
                <form action=""  method="POST">
                <label for="fname">Username</label>
                <input type="text" id="user" name="username" pattern="[^\s]+" title="Tidak boleh ada spasi" placeholder="Username..." required>
                <label for="lname">Password</label>
                <input type="password" id="pass" name="password" pattern=".{8,}" title="Masukkan minimal 8 karakter" placeholder="Password..." required>
                <input type="checkbox" name="remember" id="remember"> Ingat Saya
                <div class="btn">
                <button type="submit" id="submit" name="login" style="width: 100px; justify-content:center;"><b>Masuk</b></button> 
                </div>
                <p class="btm" >Belum punya akun? <button class="a" type="button" onclick="toggleRegister()">Daftar</button></p> 
                </form>
            </div>

    <!-- REGISTER -->
            <div class="column" id="register" style="margin-top: 8rem; padding: 0 40px 0 40px; display: none;">
            <h3 style="text-align: center;"><b>Register</b></h3>
                <form action="" method="POST">
                <label for="fname">Username</label>
                <input type="text" id="userRegist" name="username" pattern="[^\s]+" title="Tidak boleh ada spasi" placeholder="Username..." required>
                <label for="nama">Nama</label>
                <input type="text" id="nama" name="nama" placeholder="Nama" required>
                <label for="lname">Password</label>
                <input type="password" id="passRegist" name="password" pattern=".{8,}" title="Masukkan minimal 8 karakter" placeholder="Password..." required>
                <div class="btn">
                <button type="submit" id="submit" name="register" style="width: 100px; justify-content:center;"><b>Daftar</b></button> 
                </div>
                <p class="btm-regist" >Sudah punya akun? <button class="a" type="button" onclick="toggleLogin()">Masuk</button></p> 
            </form>
        </div>
        </div>
	</div>
<!-- akhir form -->
</body>

<!-- Java Script -->
<script type="text/javascript">

    // TOGGLE FORM REGISTER
    // SECTION LOGIN AKAN HILANG, DAN SECTION REGISTER AKAN MUNCUL
    function toggleRegister() {
        var login = document.getElementById("login"); //MEMANGGIL ELEMENT DENGAN ID LOGIN
        var register = document.getElementById("register"); //MEMANGGIL MEMANGGIL ELEMENT DENGAN ID REGISTER
        if (login.style.display === "block") { 
            login.style.display = "none";
            register.style = "block"
        } else {
            login.style.display = "none";
        }
    }
    //VALIDASI : TIDAK BOLEH ADA SPASI PADA KOLOM USERNAME
    function fieldValidation() { 
            var data = document.querySelector('[name = "username"]'); //MEMANGGIL FIELD USERNAME
            data.onkeypress = function(e) { 
            var  key = e.keyCode;
            return (key !== 32); //KEY 32 = SPASI
};

    }
    //TOGGLE FORM LOGIN
    function toggleLogin() {
        var login = document.getElementById("login");
        var register = document.getElementById("register");
        login.style.display = "block";
        register.style.display = "none";
    }
    //FORM REGISTER AKAN HILANG, FORM LOGIN AKAN MUNCUL
	</script>
    
<!-- Akhir Javascript -->
</html>