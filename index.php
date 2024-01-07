<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once("koneksi.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Sistem Temu Janji Poliklinik</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/poli/dist/css/welcome_styles.css">
</head>

<body>
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #0C4C93;">
        <div class="container px-5">
            <a class="navbar-brand" href="index.php">Sistem Informasi Poliklinik</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        </div>
        <ul class="navbar-nav d-flex align-items-lg-left ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="index.php?page=dokter">Data Dokter</a></li>
                                <li><a class="dropdown-item" href="index.php?page=jadwalDokter">Jadwal Dokter</a></li>
                            </ul>
                        </li>
        </ul>
    </nav>
    <?php 
        if (isset($_GET['page'])) {
            if ($_GET['page'] === 'loginAdmin') {
                include_once ('./loginAdmin.php');
            } else if ($_GET['page'] === 'loginDokter') {
                include_once ('./loginDokter.php');
            } else if ($_GET['page'] === 'loginPasien') {
                include_once ('./loginPasien.php');
            } else {
                include($_GET['page'] . ".php");
            }
        } else {
    ?>
        <!-- Header-->
    <!-- Features section-->
    <section class="py-5 border-bottom" id="features">
        <div class="container px-5 my-5">
            <div class="row g-5">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-person"></i></div>
                    <h2 class="h4 fw-bolder">Login Sebagai Admin</h2>
                    <p>Apabila Anda adalah seorang Admin, silahkan Login terlebih dahulu untuk mengelola data website!</p>
                    <a class="text-decoration-none" href="index.php?page=loginAdmin">
                        Klik Link Berikut
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-person"></i></div>
                    <h2 class="h4 fw-bolder">Login Sebagai Dokter</h2>
                    <p>Apabila Anda adalah seorang Dokter, silahkan Login terlebih dahulu untuk memulai melayani Pasien!</p>
                    <a class="text-decoration-none" href="index.php?page=loginDokter">
                        Klik Link Berikut
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-person"></i></div>
                    <h2 class="h4 fw-bolder">Login Sebagai Pasien</h2>
                    <p>Apabila Anda adalah seorang Pasien, silahkan Login terlebih dahulu untuk mulai menggunakan layanan kami!</p>
                    <a class="text-decoration-none" href="index.php?page=loginPasien">
                        Klik Link Berikut
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <?php
        }
    ?>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>