<?php
require 'controller/crudController.php';
require 'controller/sessionController.php';
checkLoginSessionHome(); //MENGECEK SESSION, ASAL FUNCTION INI DARI SESSIONCONTROLLER.PHP
if (isset($_POST["logout"])) { //JIKA BUTTON LOGOUT DITEKAN, MAKA AKAN MENJALANKAN FUNCTION LOGOUT. FUNCTION INI BERASAL DARI CRUDCONTROLLER.PHP
  logout();
}
if (isset($_POST["delete-data"])) { //JIKA BUTTON LOGOUT DITEKAN, MAKA AKAN MENJALANKAN FUNCTION LOGOUT. FUNCTION INI BERASAL DARI CRUDCONTROLLER.PHP
  deleteUserData();
}
if (isset($_POST["simpanData"])) {
  addSiswa();
}
getUserData();

?>

<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/home.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
  <title>Sistem Manajemen Sekolah - SMKN 2 SGS</title>
</head>

<body onload="onloadFunction()">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

  <div id="navbar">
    <h3>DASHBOARD ADMIN SMK NEGERI 2 SINGOSARI</h3>
    <form action="" method="post">
      <a href=""><button style="margin-top: 2px;" type="submit" onclick=" return confirm('Yakin ingin keluar ?')" class="logout bi bi-door-open" name="logout">Keluar</button></a>
    </form>
    <div class="vl"></div>
    <p><i style="margin-right: 2px;" class="bi bi-person-circle"></i> <?php echo ucfirst($_SESSION['name']) ?></p>
  </div>
  <div class="sidebar">
    <a href="#beranda" id="btnberanda" onclick="beranda()">Beranda</a>
    <a href="#masteruser" id="btnmasteruser" onclick="masterUser()">Daftar Siswa</a>
  </div>

  <section id="beranda">
    <div class="content">
      <div style="margin-top: 5rem;">
        <h2>Indeks Jumlah Siswa</h2>
        <div class="row">
          <div class="column">
            <canvas id="myChart" style="width:100%;max-width:500px"></canvas>
          </div>
          <div class="column">
            <canvas id="myChart2" style="width:100%;max-width:500px"></canvas>
          </div>
        </div>
        <div class="row">
          <div class="column">
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. At laborum aliquid architecto aliquam nostrum dolores explicabo corrupti excepturi. Repudiandae quibusdam repellendus saepe odio laborum eveniet maiores, doloremque reprehenderit minima ad architecto possimus sequi expedita, at molestias iusto molestiae corrupti nulla?</p>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. At laborum aliquid architecto aliquam nostrum dolores explicabo corrupti excepturi. Repudiandae quibusdam repellendus saepe odio laborum eveniet maiores, doloremque reprehenderit minima ad architecto possimus sequi expedita, at molestias iusto molestiae corrupti nulla?</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section id="masteruser">
    <div class="content">
      <div style="margin-top: 5rem;">
        <div class="row">
          <div class="col">
            <h2 style="margin: 0; width:fit-content; height:fit-content;">Daftar Siswa</h2>
          </div>
          <div class="col">
            <button class="button-tambah" id="btnAdd"><i class="bi bi-plus-lg"></i> Tambah Data</button>
          </div>
        </div>
        <div class="row">
          <table class="styled-table display" id="table_id">
            <thead>
              <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama Lengkap</th>
                <th>Alamat</th>
                <th>Tahun Ajaran</th>
                <th>Status</th>
                <th style="text-align: center;">Aksi</th>
            </thead>
            </tr>
            <?php $count = 1;
            while ($userdata = mysqli_fetch_array($_REQUEST['queryGetUser'], MYSQLI_ASSOC)) { ?>
              <tr>
                <td><?= $count ?></td>
                <td><?= $userdata['nis'] ?></td>
                <td><?= $userdata['name'] ?></td>
                <td><?= $userdata['address'] ?></td>
                <td><?= $userdata['tahun_ajaran'] ?></td>
                <td><?php if ($userdata['is_active'] === '1') {
                      echo 'Aktif';
                    } else {
                      echo 'Nonaktif';
                    } ?></td>
                <td>
                  <div class="row" style="text-align:center;">
                    <div class="col">
                      <button id="btnUpdate" class="button-edit"><i class="bi bi-pencil-fill"></i></button>
                    </div>
                    <div class="col">
                      <form action="#masteruser" method="post">
                        <button class="button-hapus" type="submit" name="delete-data" value="<?= $userdata['id_siswa'] ?>" onclick=" return confirm('Ingin menghapus data ini ? Aksi ini tidak dapat dibatalkan')"><i class="bi bi-trash-fill"></i></button>
                    </div>
                  </div>
                </td>
                </form>
              </tr>
            <?php $count++;
            } ?>
          </table>
        </div>
      </div>
    </div>
  </section>

  <!-- ADD USER -->
  <div id="addUser" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
      <form action="" method="post">
        <span class="close">&times;</span>
        <div>
          <p>Tambah Data Siswa</p>
        </div>
        <div>
          <div class="row">
            <div class="col">
              <p>NIS</p>
            </div>
            <div class="col">
              <input type="text" name="nis">
            </div>
          </div>
          <div class="row">
            <div class="col">
              <p>Nama Lengkap</p>
            </div>
            <div class="col">
              <input type="text" name="namalengkap">
            </div>
          </div>
          <div class="row">
            <div class="col">
              <p>Alamat</p>
            </div>
            <div class="col"><input type="text" name="alamat"></div>
          </div>
          <div class="row">
            <div class="col">
              <p>Tahun Ajaran</p>
            </div>
            <div class="col">
              <div class="row">
                <div class="col"><input type="text" name="tahunawal"></div>
                <p style="margin: 0 2px 0 2px;">s/d</p>
                <div class="col"><input type="text" name="tahunakhir"></div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <p>Status</p>
            </div>
            <div class="col"><select name="statusSiswa" id="status">
                <option value="0">Nonaktif</option>
                <option value="1" selected>Aktif</option>
              </select></div>
          </div>
        </div>
        <div>
          <button type="submit" name="simpanData">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <!-- UPDATE USER -->
  <div id="updateUser" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
      <form action="" method="post">
        <span class="close">&times;</span>
        <div>
          <p>Update Data Siswa</p>
        </div>
        <div>
          <div class="row">
            <div class="col">
              <p>NIS</p>
            </div>
            <div class="col">
              <input type="text" name="nisupdate" value="">
            </div>
          </div>
          <div class="row">
            <div class="col">
              <p>Nama Lengkap</p>
            </div>
            <div class="col">
              <input type="text" name="namalengkapupdate">
            </div>
          </div>
          <div class="row">
            <div class="col">
              <p>Alamat</p>
            </div>
            <div class="col"><input type="text" name="alamatupdate"></div>
          </div>
          <div class="row">
            <div class="col">
              <p>Tahun Ajaran</p>
            </div>
            <div class="col">
              <div class="row">
                <div class="col"><input type="text" name="tahunawalupdate"></div>
                <p style="margin: 0 2px 0 2px;">s/d</p>
                <div class="col"><input type="text" name="tahunakhirupdate"></div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <p>Status</p>
            </div>
            <div class="col"><select name="statusSiswaupdate" id="status">
                <option value="0">Nonaktif</option>
                <option value="1" selected>Aktif</option>
              </select></div>
          </div>
        </div>
        <div>
          <button type="submit" name="updateData">Simpan</button>
        </div>
      </form>
    </div>
  </div>
  <script>
    var berandaa = document.getElementById("beranda");
    var masteruser = document.getElementById("masteruser");
    var btnberanda = document.getElementById("btnberanda");
    var btnmasteruser = document.getElementById("btnmasteruser");
    var btnadd = document.getElementById("btnAdd");
    var btnupdate = document.getElementById("btnUpdate");
    var modal = document.getElementById("addUser");
    var modalupdate = document.getElementById("updateUser");
    var span = document.getElementsByClassName("close")[0];
    var spanUpdate = document.getElementsByClassName("close")[1];
    span.onclick = function() {
      modal.style.display = "none";
    }
    spanUpdate.onclick = function() {
      modalupdate.style.display = "none";
    }

    btnadd.onclick = function() {
      modal.style.display = "block";
    }

    btnupdate.onclick = function() {
      modalupdate.style.display = "block";
    }




    function onloadFunction() {
      // window.location = "http://127.0.0.1:8080/login_k2/home.php#beranda"
      masteruser.style.display = "none";
      berandaa.style.display = "block";
      btnberanda.classList.add("active")

    }
    //get section id

    // if (window.location.pathname = "/login_k2/home.php#beranda") {
    //   masteruser.style.display = "none";
    //   berandaa.style.display = "block";
    //   btnberanda.classList.add("active");
    //   btnmasteruser.classList.remove("active");
    // }
    // if (window.location.pathname = "/login_k2/home.php#masteruser") {
    //   masteruser.style.display = "block";
    //   berandaa.style.display = "none";
    //   btnberanda.classList.remove("active");
    //   btnmasteruser.classList.add("active");
    // }

    function beranda() {
      masteruser.style.display = "none";
      berandaa.style.display = "block";
      btnberanda.classList.add("active");
      btnmasteruser.classList.remove("active");
    }

    function masterUser() {
      masteruser.style.display = "block";
      berandaa.style.display = "none";
      btnberanda.classList.remove("active");
      btnmasteruser.classList.add("active");
    }


    var xyValues = [{
        x: 2007,
        y: 300
      },
      {
        x: 2008,
        y: 450
      },
      {
        x: 2009,
        y: 555
      },
      {
        x: 2010,
        y: 612
      },
      {
        x: 2011,
        y: 713
      },
      {
        x: 2012,
        y: 819
      },
      {
        x: 2013,
        y: 991
      },
      {
        x: 2014,
        y: 1022
      },
      {
        x: 2015,
        y: 1479
      },
      {
        x: 2016,
        y: 1566
      },
      {
        x: 2017,
        y: 1790
      }
    ];

    new Chart("myChart", {
      type: "scatter",
      data: {
        datasets: [{
          pointRadius: 4,
          pointBackgroundColor: "rgb(255,0,0)",
          data: xyValues
        }]
      },
      options: {
        title: {
          display: true,
          text: 'SMK Negeri 1 Singosari'
        },
        legend: {
          display: false
        },
        scales: {
          xAxes: [{
            ticks: {
              min: 2007,
              max: 2017
            }
          }],
          yAxes: [{
            ticks: {
              min: 200,
              max: 1800
            }
          }],
        }
      }
    });
    new Chart("myChart2", {
      type: "scatter",
      data: {
        datasets: [{
          pointRadius: 4,
          pointBackgroundColor: "rgb(255,0,0)",
          data: xyValues
        }]
      },
      options: {
        title: {
          display: true,
          text: 'SMK Negeri 2 Singosari'
        },
        legend: {
          display: false
        },
        scales: {
          xAxes: [{
            ticks: {
              min: 2007,
              max: 2017
            }
          }],
          yAxes: [{
            ticks: {
              min: 200,
              max: 1800
            }
          }],
        }
      }
    });
  </script>

</body>

</html>