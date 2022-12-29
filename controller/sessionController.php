<?php

    function checkLoginSession() {
        session_start();

        if (isset($_COOKIE['username']) && isset($_SESSION['username'])) { //JIKA SESSION DAN COOKIE TELAH DI SET, MAKA DIARAHKAN KE HOME
            header("Location: home.php");
        } 
    }
    function checkLoginSessionHome() {
       session_start();
        if (!isset($_COOKIE['username']) && !isset($_SESSION['username'])) { //JIKA SESSION DAN COOKIE BELUM DI SET, MAKA DIARAHKAN KE HALAMAN LOGIN
            // header("Location : index.php");
            echo '<script>alert("silahkan login terlebih dahulu"); window.location = "index.php"</script>'; //ALERT HARUS LOGIN TERLEBIH DAHULU
            
        }
    }
   
?>