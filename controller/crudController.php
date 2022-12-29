<?php
$koneksi = mysqli_connect("localhost", "root", "", "kelompok2");
if (!$koneksi) {
    die("<script>alert('Connection Error')</script>");
}

//FUNCTION LOGIN
function login($data)
{ //$DATA DIDAPATKAN DARI PASSING DATA $_POST 
    global $koneksi;

    $user = $data['username'];
    $pass = md5($data['password']);

    $sql = "SELECT * FROM m_user WHERE username ='$user' AND password ='$pass'"; //QUERY MYSQL
    $result = mysqli_query($koneksi, $sql);
    if ($result->num_rows > 0) { //JIKA HASIL QUERY DITEMUKAN, MAKA AKAN MENJALANKAN FUNGSI DIBAWAH
        $row = mysqli_fetch_assoc($result);

        session_start();
        $_SESSION['username'] = $row['username']; //SET SESSION
        $_SESSION['name'] = $row['name'];
        if (isset($_POST['remember'])) { //JIKA CHECKBOX INGAT SAYA DICENTANG, MAKA UMUR COOKIE SET MENJADI 7 HARI
            setcookie("username", $_POST['username'], time() + (60 * 60 * 24 * 7), "/");
        } else {
            setcookie("username", $_POST['password'], time() + (60 * 60 * 24), "/"); //JIKA TIDAK DICENTANG, MAKA UMUR COOKIE HANYA 1 JAM
        }
        header("Location: home.php"); //REDIRECT KE HALAMAN HOME
    } else {
        echo "<script>alert('username atau password salah')</script>"; //ALERT JIKA USERNAME ATAU PASSWORD SALAH
    }
}

//FUNCTION LOGOUT
function logout()
{
    setcookie("username", "", time() - 3600, "/"); //SET COOKIE MENJADI KOSONG
    unset($_COOKIE['username']); //MENGHAPUS COOKIE
    session_start();
    session_destroy(); //MENGHAPUS SESSION
    header("Location: index.php"); //REDIRECT KE HALAMAN LOGIN

}

//FUNCTION REGISTER
function register($data)
{
    global $koneksi;


    //DEKLARASI VARIABEL
    $username = mysqli_real_escape_string($koneksi, $data["username"]);
    $nama = mysqli_real_escape_string($koneksi, $data["nama"]);
    $password = md5(mysqli_real_escape_string($koneksi, $data["password"]));

    $result = mysqli_query($koneksi, "SELECT username FROM m_user WHERE username = '$username'"); //QUERY UNTUK MENGECEK APAKAH USERNAME SUDAH ADA ATAU BELUM

    if (mysqli_fetch_assoc($result)) { //JIKA USERNAME ADA, MAKA MUNCUL ALERT DIBAWAHS
        echo "<script> alert('username sudah ada!');</script>";
        return false;
    }

    mysqli_query($koneksi, "INSERT INTO m_user VALUES (NULL,'$username', '$nama', '$password', '1')"); //JIKA USERNAME BELUM ADA, MAKA DATA AKAN DITAMBAH KE DATABASE
    return mysqli_affected_rows($koneksi);
}

function getUserData()
{ //GET DATA SISWA
    global $koneksi;
    $query = mysqli_query($koneksi, "SELECT * FROM m_siswa");
    $_REQUEST['queryGetUser'] = $query; //MENYIMPAN HASIL QUERY KE VARIABEL $_REQUEST
}

function deleteUserData()
{
    global $koneksi;
    $id = $_POST['delete-data'];
    mysqli_query($koneksi, "DELETE FROM m_siswa WHERE id_siswa=$id");
    echo "<script> alert('Data berhasil dihapus');</script>";
}

function addSiswa()
{
    global $koneksi;
    $nis = $_POST['nis'];
    $namalengkap = $_POST['namalengkap'];
    $alamat = $_POST['alamat'];
    $tahunajaran = $_POST['tahunawal'] . "-" . $_POST['tahunakhir'];
    $status = $_POST['statusSiswa'];
    $check = mysqli_query($koneksi, "SELECT nis FROM m_siswa WHERE nis = $nis");
    if (mysqli_fetch_assoc($check)) {
        echo "<script> alert('NIS Sudah ada !');</script>";
        return false;
    }
    mysqli_query($koneksi, "INSERT INTO `m_siswa` (`id_siswa`, `nis`, `name`, `address`, `tahun_ajaran`, `is_active`) VALUES (NULL, '$nis', '$namalengkap', '$alamat', '$tahunajaran', '$status');");
}
function updateSiswa()
{
    global $koneksi;
    $nis = $_POST['nisupdate'];
    $idsiswa = $_POST['id_siswa'];
    $namalengkap = $_POST['namalengkapupdate'];
    $alamat = $_POST['alamatupdate'];
    $tahunajaran = $_POST['tahunawalupdate'] . "-" . $_POST['tahunakhirupdate'];
    $status = $_POST['statusSiswaupdate'];
    mysqli_query($koneksi, "UPDATE `m_siswa` SET `nis` = '$nis', `name` = '$namalengkap', `address` = '$alamat', `tahun_ajaran` = '$tahunajaran', `is_active` = '$status' WHERE `m_siswa`.`id_siswa` = '$idsiswa'; ");
    echo "<script> alert('Data berhasil disimpan');</script>";
    getUserData();
}
