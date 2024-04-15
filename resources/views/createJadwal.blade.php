<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dashboard - NiceAdmin Bootstrap Template</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin - v2.2.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
    {{-- <style>
        table thead {
            position: -webkit-sticky; // this is for all Safari (Desktop & iOS), not for Chrome
            position: sticky;
            top: 0;
            z-index: 1; // any positive value, layer order is global
            background: #fff; // any bg-color to overlap
        }
    </style> --}}
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <img src="assets/img/logo.png" alt="">
                <span class="d-none d-lg-block">KDF-DURSAW</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                        data-bs-toggle="dropdown">
                        <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2">KDF-DURSAW</span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>KDF-DURSAW</h6>
                            <span>Admin</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-heading">Home</li>

            <li class="nav-item"> <!-- Start Dashboard Nav -->
                <a class="nav-link " href="#">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-heading">Pages</li>

            <li class="nav-item"> <!-- Start Guru Nav -->
                <a class="nav-link collapsed" href="#">
                    <i class="bi bi-person"></i>
                    <span>Guru</span>
                </a>
            </li><!-- End Guru Page Nav -->

            <li class="nav-item"> <!-- Start Kelas Page Nav -->
                <a class="nav-link collapsed" href="#">
                    <i class="bi bi-question-circle"></i>
                    <span>Kelas</span>
                </a>
            </li><!-- End Kelas Page Nav -->

            <li class="nav-item"> <!-- Start Mata Pelajaran Page Nav -->
                <a class="nav-link collapsed" href="#">
                    <i class="bi bi-envelope"></i>
                    <span>Mata Pelajaran</span>
                </a>
            </li><!-- End Mata Pelajaran Page Nav -->

            <li class="nav-item"> <!-- Start Departmen Page Nav -->
                <a class="nav-link collapsed" href="#">
                    <i class="bi bi-card-list"></i>
                    <span>Departmen</span>
                </a>
            </li><!-- End Departmen Page Nav -->

            <li class="nav-item"> <!-- End Jadwal Page Nav -->
                <a class="nav-link collapsed" href="#">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Jadwal</span>
                </a>
            </li><!-- End Jadwal Page Nav -->

        </ul>

    </aside><!-- End Sidebar-->

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                {{-- Start content --}}
                <div class="col-lg">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <div class="card-title ">Buat Jadwal</div>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="4" class="text-center">2023-2024</th>
                                        @foreach ($data['kelas'] as $item)
                                            <th>{{ $item }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['jadwal'] as $keyX => $item)
                                        @foreach ($item as $keyY => $jadwal)
                                            @php
                                                $customClass = '';
                                                if (in_array($keyY, [0, 5, 9, 13])) {
                                                    $customClass = 'table-secondary';
                                                }
                                            @endphp
                                            <tr class="{{ $customClass }}">
                                                @if ($keyY === array_key_first($item))
                                                    <td scope="row" rowspan="14"
                                                        class="text-center align-middle fw-bold">
                                                        {{ $keyX }}</td>
                                                @endif
                                                <td>{{ $data['jam'][$keyY][0] }}</td>
                                                <td>{{ $data['jam'][$keyY][1] }}</td>
                                                <td>{{ $data['jam'][$keyY][2] }}</td>
                                                @foreach ($jadwal as $keyZ => $itemJadwal)
                                                    <td>{{ is_string($itemJadwal) ? $itemJadwal : $itemJadwal['nama_mata_pelajara'] }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                        <tr class="table-dark">
                                            <td colspan="18"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->
                        </div>
                    </div>
                </div>
                {{-- End content --}}
            </div>
        </section>

    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>
