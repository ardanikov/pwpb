<?php
require 'controller/crudController.php';
require 'controller/sessionController.php';
checkLoginSessionHome(); //MENGECEK SESSION, ASAL FUNCTION INI DARI SESSIONCONTROLLER.PHP
getUserData();
getGuruData();
?>

<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/home.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
  <title>Sistem Manajemen Sekolah - SMKN 2 SGS</title>
  <script>
    /*to prevent Firefox FOUC, this must be here*/
    let FF_FOUC_FIX;
  </script>
</head>
<?php
if (isset($_POST["logout"])) { //JIKA BUTTON LOGOUT DITEKAN, MAKA AKAN MENJALANKAN FUNCTION LOGOUT. FUNCTION INI BERASAL DARI CRUDCONTROLLER.PHP
  logout();
}
if (isset($_POST["delete-data"])) {
  deleteUserData();
}
if (isset($_POST["delete-dataguru"])) {
  deleteGuruData();
}
if (isset($_POST["simpanData"])) {
  addSiswa();
}
if (isset($_POST["simpanDataGuru"])) {
  addGuru();
}
if (isset($_POST["updateData"])) {
  updateSiswa();
}
if (isset($_POST["updateGuru"])) {
  updateGuru();
}


?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<body onload="onloadFunction()">

  <!-- NAVBAR -->
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
    <a href="#masterguru" id="btnmasterguru" onclick="masterGuru()">Daftar Guru</a>
  </div>

  <!-- BERANDA -->
  <section id="beranda">
    <div class="content">
      <div style="margin-top: 5rem;">
        <h2>Indeks Jumlah Siswa</h2>
        <div class="row-flex">
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

  <!-- DAFTAR SISWA -->
  <section id="masteruser">
    <div class="content">
      <div style="margin-top: 5rem;">
        <div class="row">
          <div class="col">
            <h2 style="margin: 0; width:fit-content; height:fit-content;">Daftar Siswa</h2>
            <input type="text" onkeyup="searchNameSiswa()" placeholder="Cari Nama" id="SearchNamaSiswa">
          </div>
          <div class="col">
            <input type="text" class="none">
            <button class="button-tambah" id="btnAdd"><i class="bi bi-plus-lg"></i> Tambah Data</button>
          </div>
        </div>
        <div class="row">
          <table class="styled-table display table-sortable" id="table_siswa">
            <thead>
              <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama Lengkap</th>
                <th>Alamat</th>
                <th>Tahun Ajaran</th>
                <th>Status</th>
                <th style="text-align: center;  width:70px;">Aksi</th>
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
                    <div class="col" onclick="editDetail({
                      id : '<?= $userdata['id_siswa'] ?>',
                      nis : '<?= $userdata['nis'] ?>',
                      name : '<?= $userdata['name'] ?>',
                      address : '<?= $userdata['address'] ?>',
                      tahunajaran : '<?= $userdata['tahun_ajaran'] ?>',
                      is_active : '<?= $userdata['is_active'] ?>',
                      })">
                      <button id="btnUpdate" onclick="updateModal()" class="button-edit"><i class="bi bi-pencil-fill"></i></button>
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

  <!-- DAFTAR GURU -->
  <section id="masterguru">
    <div class="content">
      <div style="margin-top: 5rem;">
        <div class="row">
          <div class="col">
            <h2 style="margin: 0; width:fit-content; height:fit-content;">Daftar Guru</h2>
            <input type="text" onkeyup="searchNameGuru()" placeholder="Cari Nama" id="SearchNamaGuru">
          </div>
          <div class="col">
            <input type="text" class="none">
            <button class="button-tambah" id="btnAddGuru"><i class="bi bi-plus-lg"></i> Tambah Data</button>
          </div>
        </div>
        <div class="row">
          <table class="styled-table display table-sortable" id="table_guru">
            <thead>
              <tr>
                <th>No</th>
                <th>NIG</th>
                <th>Nama Lengkap</th>
                <th>Alamat</th>
                <!-- <th>Tahun Mengajar</th> -->
                <th>Status</th>
                <th style="text-align: center;  width:70px;">Aksi</th>
            </thead>
            </tr>
            <?php $count = 1;
            while ($userdata = mysqli_fetch_array($_REQUEST['queryGetGuru'], MYSQLI_ASSOC)) { ?>
              <tr>
                <td><?= $count ?></td>
                <td><?= $userdata['nig'] ?></td>
                <td><?= $userdata['name'] ?></td>
                <td><?= $userdata['address'] ?></td>

                <td><?php if ($userdata['is_active'] === '1') {
                      echo 'Aktif';
                    } else {
                      echo 'Nonaktif';
                    } ?></td>
                <td>
                  <div class="row" style="text-align:center;">
                    <div class="col" onclick="editDetailGuru({
                      id : '<?= $userdata['id_guru'] ?>',
                      nig : '<?= $userdata['nig'] ?>',
                      name : '<?= $userdata['name'] ?>',
                      address : '<?= $userdata['address'] ?>',
                      is_active : '<?= $userdata['is_active'] ?>',
                      })">
                      <button id="btnUpdate" onclick="updateGuruModal()" class="button-edit"><i class="bi bi-pencil-fill"></i></button>
                    </div>
                    <div class="col">
                      <form action="#masterguru" method="post">
                        <button class="button-hapus" type="submit" name="delete-dataguru" value="<?= $userdata['id_guru'] ?>" onclick=" return confirm('Ingin menghapus data ini ? Aksi ini tidak dapat dibatalkan')"><i class="bi bi-trash-fill"></i></button>
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


  <!-- MODALS -->

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
              <input type="number" minlength="4" maxlength="20" name="nis">
            </div>
          </div>
          <div class="row">
            <div class="col">
              <p>Nama Lengkap</p>
            </div>
            <div class="col">
              <input type="text" minlength="2" maxlength="50" name="namalengkap">
            </div>
          </div>
          <div class="row">
            <div class="col">
              <p>Alamat</p>
            </div>
            <div class="col"><input type="text" minlength="4" maxlength="200" name="alamat"></div>
          </div>
          <div class="row">
            <div class="col">
              <p>Tahun Ajaran</p>
            </div>
            <div class="col">
              <div class="row">
                <div class="col"><input type="number" minlength="4" maxlength="4" name="tahunawal"></div>
                <p style="margin: 0 2px 0 2px;">s/d</p>
                <div class="col"><input type="number" minlength="4" maxlength="4 " name="tahunakhir"></div>
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
          <button type="submit" name="simpanData" class="button-tambah" onclick="return confirmAction()">Simpan</button>
        </div>
      </form>
    </div>
  </div>
  <!-- ADD GURU -->
  <div id="addGuru" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
      <form action="" method="post">
        <span class="closeGuru">&times;</span>
        <div>
          <p>Tambah Data Guru</p>
        </div>
        <div>
          <div class="row">
            <div class="col">
              <p>NIG</p>
            </div>
            <div class="col">
              <input type="number" minlength="4" maxlength="20" name="nig">
            </div>
          </div>
          <div class="row">
            <div class="col">
              <p>Nama Lengkap</p>
            </div>
            <div class="col">
              <input type="text" minlength="2" maxlength="50" name="namalengkapguru">
            </div>
          </div>
          <div class="row">
            <div class="col">
              <p>Alamat</p>
            </div>
            <div class="col"><input type="text" minlength="4" maxlength="200" name="alamatguru"></div>
          </div>
          <!-- <div class="row">
            <div class="col">
              <p>Tahun Mengajar</p>
            </div>
            <div class="col">
              <div class="row">
                <div class="col"><input type="number" minlength="4" maxlength="4" name="tahunawalguru"></div>
                <p style="margin: 0 2px 0 2px;">s/d</p>
                <div class="col"><input type="number" minlength="4" maxlength="4 " name="tahunakhirguru"></div>
              </div>
            </div>
          </div> -->
          <div class="row">
            <div class="col">
              <p>Status</p>
            </div>
            <div class="col"><select name="statusGuru" id="status">
                <option value="0">Nonaktif</option>
                <option value="1" selected>Aktif</option>
              </select></div>
          </div>
        </div>
        <div>
          <button type="submit" name="simpanDataGuru" class="button-tambah" onclick="return confirmAction()">Simpan</button>
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
              <input type="number" minlength="4" maxlength="20" name="nisupdate" id="nisupdate">
              <input type="text" style="display: none;" name="id_siswa" id="id_siswa">
            </div>
          </div>
          <div class="row">
            <div class="col">
              <p>Nama Lengkap</p>
            </div>
            <div class="col">
              <input type="text" minlength="2" maxlength="50" name="namalengkapupdate" id="namalengkapupdate">
            </div>
          </div>
          <div class="row">
            <div class="col">
              <p>Alamat</p>
            </div>
            <div class="col"><input type="text" minlength="4" maxlength="200" name="alamatupdate" id="alamatupdate"></div>
          </div>
          <div class="row">
            <div class="col">
              <p>Tahun Ajaran</p>
            </div>
            <div class="col">
              <div class="row">
                <div class="col"><input type="number" minlength="4" maxlength="4" name="tahunawalupdate" id="tahunawalupdate"></div>
                <p style="margin: 0 2px 0 2px;">s/d</p>
                <div class="col"><input type="number" minlength="4" maxlength="4" name="tahunakhirupdate" id="tahunakhirupdate"></div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <p>Status</p>
            </div>
            <div class="col"><select name="statusSiswaupdate" id="statusupdate">
                <option value="0">Nonaktif</option>
                <option value="1" selected>Aktif</option>
              </select></div>
          </div>
        </div>
        <div>
          <button type="submit" name="updateData" class="button-tambah" onclick=" return confirm('Yakin data sudah benar ?')">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <!-- UPDATE Guru -->
  <div id="updateGuru" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
      <form action="" method="post">
        <span class="closeGuruUpdate">&times;</span>
        <div>
          <p>Update Data Guru</p>
        </div>
        <div>
          <div class="row">
            <div class="col">
              <p>NIG</p>
            </div>
            <div class="col">
              <input type="number" minlength="4" maxlength="20" name="nigupdate" id="nigupdate">
              <input type="text" style="display: none;" name="id_guru" id="id_guru">
            </div>
          </div>
          <div class="row">
            <div class="col">
              <p>Nama Lengkap</p>
            </div>
            <div class="col">
              <input type="text" minlength="2" maxlength="50" name="namalengkapguruupdate" id="namalengkapguruupdate">
            </div>
          </div>
          <div class="row">
            <div class="col">
              <p>Alamat</p>
            </div>
            <div class="col"><input type="text" minlength="4" maxlength="200" name="alamatguruupdate" id="alamatguruupdate"></div>
          </div>
          <!-- <div class="row">
            <div class="col">
              <p>Tahun Mengajar</p>
            </div>
            <div class="col">
              <div class="row">
                <div class="col"><input type="number" minlength="4" maxlength="4" name="tahunawalguruupdate" id="tahunawalguruupdate"></div>
                <p style="margin: 0 2px 0 2px;">s/d</p>
                <div class="col"><input type="number" minlength="4" maxlength="4" name="tahunakhirguruupdate" id="tahunakhirguruupdate"></div>
              </div>
            </div>
          </div> -->
          <div class="row">
            <div class="col">
              <p>Status</p>
            </div>
            <div class="col"><select name="statusGuruupdate" id="statusguruupdate">
                <option value="0">Nonaktif</option>
                <option value="1" selected>Aktif</option>
              </select></div>
          </div>
        </div>
        <div>
          <button type="submit" name="updateGuru" class="button-tambah" onclick=" return confirm('Yakin data sudah benar ?')">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    var berandaa = document.getElementById("beranda");
    var masteruser = document.getElementById("masteruser");
    var masterguru = document.getElementById("masterguru");
    var btnberanda = document.getElementById("btnberanda");
    var btnmasteruser = document.getElementById("btnmasteruser");
    var btnmasterguru = document.getElementById("btnmasterguru");
    var btnadd = document.getElementById("btnAdd");
    var btnaddguru = document.getElementById("btnAddGuru");
    var btnupdate = document.getElementById("btnUpdate");
    var modal = document.getElementById("addUser");
    var modalguru = document.getElementById("addGuru");
    var modalupdate = document.getElementById("updateUser");
    var modalupdateguru = document.getElementById("updateGuru");
    var span = document.getElementsByClassName("close")[0];
    var spanUpdate = document.getElementsByClassName("close")[1];
    var spanGuruUpdate = document.getElementsByClassName("closeGuruUpdate")[0];
    var spanGuru = document.getElementsByClassName("closeGuru")[0];
    var dataModal = {};

    function searchNameGuru() {
      console.log('working');
      let input, filter, table, tr, td, txtValue;
      input = document.getElementById("SearchNamaGuru")
      filter = input.value.toUpperCase()
      table = document.getElementById("table_guru")
      tr = table.getElementsByTagName("tr");
      for (let i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[2]
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = ""
          } else {
            tr[i].style.display = "none";
          }
        }

      }
    }

    function searchNameSiswa() {
      console.log('working');
      let input, filter, table, tr, td, txtValue;
      input = document.getElementById("SearchNamaSiswa")
      filter = input.value.toUpperCase()
      table = document.getElementById("table_siswa")
      tr = table.getElementsByTagName("tr");
      for (let i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[2]
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = ""
          } else {
            tr[i].style.display = "none";
          }
        }

      }
    }
    span.onclick = function() {
      modal.style.display = "none";
    }
    spanGuru.onclick = function() {
      modalguru.style.display = "none";
    }
    spanUpdate.onclick = function() {
      modalupdate.style.display = "none";
    }
    spanGuruUpdate.onclick = function() {
      modalupdateguru.style.display = "none";
    }

    btnadd.onclick = function() {
      modal.style.display = "block";
    }
    btnaddguru.onclick = function() {
      modalguru.style.display = "block";
    }

    function updateModal() {
      modalupdate.style.display = "block";
    }

    function updateGuruModal() {
      modalupdateguru.style.display = "block";
    }




    function onloadFunction() {
      // window.location.hash = '#beranda';
      btnberanda.classList.add("active")
      if (window.location.hash == '#beranda') {
        masteruser.style.display = "none";
        masterguru.style.display = "none";
        berandaa.style.display = "block";
        btnberanda.classList.add("active");
        btnmasteruser.classList.remove("active");
        btnmasterguru.classList.remove("active");
      }
      if (window.location.hash == '') {
        masteruser.style.display = "none";
        masterguru.style.display = "none";
        berandaa.style.display = "block";
        btnberanda.classList.add("active");
        btnmasteruser.classList.remove("active");
        btnmasterguru.classList.remove("active");
      }
      if (window.location.hash == '#masteruser') {
        masteruser.style.display = "block";
        berandaa.style.display = "none";
        masterguru.style.display = "none";
        btnberanda.classList.remove("active");
        btnmasterguru.classList.remove("active");
        btnmasteruser.classList.add("active");
      }
      if (window.location.hash == '#masterguru') {
        masterguru.style.display = "block";
        masteruser.style.display = "none";
        berandaa.style.display = "none";
        btnberanda.classList.remove("active");
        btnmasteruser.classList.remove("active");
        btnmasterguru.classList.add("active");
      }

    }

    function beranda() {
      window.location.hash = '#beranda'
      if (window.location.hash == '#beranda') {
        masteruser.style.display = "none";
        masterguru.style.display = "none";
        berandaa.style.display = "block";
        btnberanda.classList.add("active");
        btnmasteruser.classList.remove("active");
        btnmasterguru.classList.remove("active");
        console.log(window.location.hash);
      }

    }

    function masterUser() {
      window.location.hash = '#masteruser'
      if (window.location.hash == '#masteruser') {
        masteruser.style.display = "block";
        berandaa.style.display = "none";
        masterguru.style.display = "none";
        btnberanda.classList.remove("active");
        btnmasterguru.classList.remove("active");
        btnmasteruser.classList.add("active");
        console.log(window.location.hash);
      }

    }

    function masterGuru() {
      window.location.hash = '#masterguru'
      if (window.location.hash == '#masterguru') {
        masterguru.style.display = "block";
        berandaa.style.display = "none";
        masteruser.style.display = "none";
        btnberanda.classList.remove("active");
        btnmasteruser.classList.remove("active");
        btnmasterguru.classList.add("active");
        console.log(window.location.hash);
      }

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

    function editDetail(params) {
      this.dataModal = params
      document.getElementById("id_siswa").value = params['id'];
      document.getElementById("nisupdate").value = params['nis'];
      document.getElementById("namalengkapupdate").value = params['name'];
      document.getElementById("alamatupdate").value = params['address'];
      document.getElementById("statusupdate").value = params['is_active'];
      document.getElementById("tahunawalupdate").value = params['tahunajaran'].slice(-9, -5);
      document.getElementById("tahunakhirupdate").value = params['tahunajaran'].slice(-4);
    }

    function editDetailGuru(params) {
      console.log(params);
      document.getElementById("id_guru").value = params['id'];
      document.getElementById("nigupdate").value = params['nig'];
      document.getElementById("namalengkapguruupdate").value = params['name'];
      document.getElementById("alamatguruupdate").value = params['address'];
      document.getElementById("statusGuruupdate").value = params['is_active'];
      // document.getElementById("tahunawalguruupdate").value = params['tahunmengajar'].slice(-9, -5);
      // document.getElementById("tahunakhirguruupdate").value = params['tahunmengajar'].slice(-4);
    }

    function sortTableByColumn(table, column, asc = true) {
      const dirModifier = asc ? 1 : -1;
      const tBody = table.tBodies[0];
      const rows = Array.from(tBody.querySelectorAll("tr"));

      // Sort each row
      const sortedRows = rows.sort((a, b) => {
        const aColText = a.querySelector(`td:nth-child(${ column + 1 })`).textContent.trim();
        const bColText = b.querySelector(`td:nth-child(${ column + 1 })`).textContent.trim();

        return aColText > bColText ? (1 * dirModifier) : (-1 * dirModifier);
      });

      // Remove all existing TRs from the table
      while (tBody.firstChild) {
        tBody.removeChild(tBody.firstChild);
      }

      // Re-add the newly sorted rows
      tBody.append(...sortedRows);

      // Remember how the column is currently sorted
      table.querySelectorAll("th").forEach(th => th.classList.remove("th-sort-asc", "th-sort-desc"));
      table.querySelector(`th:nth-child(${ column + 1})`).classList.toggle("th-sort-asc", asc);
      table.querySelector(`th:nth-child(${ column + 1})`).classList.toggle("th-sort-desc", !asc);
    }

    document.querySelectorAll(".table-sortable th").forEach(headerCell => {
      headerCell.addEventListener("click", () => {
        const tableElement = headerCell.parentElement.parentElement.parentElement;
        const headerIndex = Array.prototype.indexOf.call(headerCell.parentElement.children, headerCell);
        const currentIsAscending = headerCell.classList.contains("th-sort-asc");

        sortTableByColumn(tableElement, headerIndex, !currentIsAscending);
      });
    });
  </script>

</body>

</html>