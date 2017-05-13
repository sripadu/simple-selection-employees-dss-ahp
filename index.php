<?php session_start(); require_once("config.php");
if (!isset($_SESSION["role"])) {
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pemilihan Pegawai Terbaik</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="assets/css/sweetalert.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/sweetalert.min.js"></script>
    <script src="assets/js/app.js"></script>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li <?=activeMenu($_PAGE, "home");?>><a href="?page=home">Home <span class="sr-only">(current)</span></a></li>
                    <?php if ($_SESSION["role"] == "Pegawai"): ?>
                        <li <?=activeMenu($_PAGE, "pegawai");?>><a href="?page=pegawai">Pegawai</a></li>
                        <li <?=activeMenu($_PAGE, "pengguna");?>><a href="?page=pengguna">Pengguna</a></li>
                    <?php endif; ?>

                    <?php if ($_SESSION["role"] == "Manajer"): ?>
                        <li <?=activeMenu($_PAGE, "kriteria");?>><a href="?page=kriteria">Kriteria</a></li>
                        <li <?=activeMenu($_PAGE, "penilaian");?>><a href="?page=penilaian">Penilaian</a></li>
                    <?php endif; ?>

                    <?php if ($_SESSION["role"] == "Atasan" OR $_SESSION["role"] == "Manajer"): ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Laporan <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="?page=pegawai&laporan">Pegawai</a></li>
                                <li><a href="?page=kriteria&laporan">Kriteria</a></li>
                                <li><a href="?page=penilaian&laporan">Penialain</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong class="text-red"><?=$_SESSION["role"]?></strong> <span class="caret"></span></a>
                      <ul class="dropdown-menu">
                          <li><a href="?logout">Logout</a></li>
                      </ul>
                    </li>
                </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container -->
        </nav>
        <?php include(paging()); ?>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap-datepicker.min.js"></script>
</body>
</html>
