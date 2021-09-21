<!doctype html>
<html lang="en">

<head>
  <title>Home - PKM APPS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css?family=DM+Sans:300,400,700|Indie+Flower" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" />
  <link rel="stylesheet" href="{{ asset('vendor/kiddy/fonts/icomoon/style.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/kiddy/fonts/flaticon/font/flaticon.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/kiddy/css/bootstrap.min.css') }}">

  <!-- MAIN CSS -->
  <link rel="stylesheet" href="{{ asset('vendor/kiddy/css/style.css') }}">

</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">


  <div class="site-wrap" id="home-section">

    <div class="site-mobile-menu site-navbar-target">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>



    <header class="site-navbar site-navbar-target" role="banner">

      <div class="container mb-3">
        <div class="d-flex align-items-center">
          <div class="site-logo mr-auto">
            <a href="/">PKM APPS<span class="text-primary">.</span></a>
          </div>
          <div class="site-quick-contact d-none d-lg-flex ml-auto ">
            <div class="d-flex site-info align-items-center mr-5">
              <!-- <span class="block-icon mr-3"><span class="icon-map-marker text-yellow"></span></span>
              <span>34 Street Name, City Name Here, <br> United States</span> -->
            </div>
            <div class="d-flex site-info align-items-center">
              <!-- <span class="block-icon mr-3"><span class="icon-clock-o"></span></span>
              <span>Sunday - Friday 8:00AM - 4:00PM <br> Saturday CLOSED</span> -->
            </div>

          </div>
        </div>
      </div>
    </header>

    <div class="ftco-blocks-cover-1">

      <div class="site-section-cover overlay" data-stellar-background-ratio="0.5" style="background-image: url('assets/img/pnc.jpg')">
        <div class="container">
          <div class="row align-items-center ">
            <div class="col-md-5 mt-5 pt-5">
              <h1 class="mb-3 font-weight-bold text-teal">Program Kreativitas Mahasiswa (PKM)</h1><br>
              <h2 class="mb-3 font-weight-bold text-teal">Oleh PNC</h2>
              <p class="mt-5">
                <a href="{{ route('register') }}" class="btn btn-primary py-4 btn-custom-1">Daftar Sekarang</a>
                <a href="{{ route('login') }}" class="btn btn-success py-4 btn-custom-1 ml-3">Login Sekarang</a>
              </p>
              <!-- <p class="mt-5"><a href="#" class="btn btn-primary py-4 btn-custom-1">Learn More</a></p> -->
            </div>
            <div class="col-md-6 ml-auto align-self-end">

            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section bg-light">
      <div class="container">
        <div class="row">
          <div class="col-md-6 mb-5 mb-md-0">
            <img src="assets/img/PKM.png" alt="Image" class="img-fluid" width="400px">
          </div>
          <div class="col-md-5 ml-auto pl-md-5">
            <h3 class="text-black">Apa itu PKM ?</h3>
            <p style="text-align: justify;"><span>PKM atau Program Kreativitas Mahasiswa
                adalah suatu wadah yang dibentuk oleh Direktorat Jenderal Pembelajaran dan Kemahasiswaan Kementerian Riset, Teknologi, dan Pendidikan Tinggi Republik Indonesia (sekarang sudah berganti kementrian dibawah kemendikbud)
                dalam memfasilitasi potensi yang dimiliki mahasiswa Indonesia untuk mengkaji, mengembangkan, dan menerapkan ilmu dan teknologi yang telah dipelajarinya di perkuliahan kepada masyarakat luas.
              </span></p>

          </div>
        </div>
      </div>
    </div>


    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <center>
              <h2>Alur Pengajuan PKM</h2>
            </center>
          </div><br><br><br>
          <div class="col-lg-3">
            <div class="block-2 red">
              <span class="wrap-icon">
                <span>1</span>
              </span>
              <h2>Registrasi Ketua Kelompok</h2>
              <p>Ketua Kelompok melakukan registrasi <a href="{{ route('register') }}" style="color: white;">disini</a></p>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="block-2 yellow">
              <span class="wrap-icon">
                <span>2</span>
              </span>
              <h2>Daftarkan Anggota Kelompoknya</h2>
              <p>Ketua Kelompok mendaftarkan anggota kelompoknya</p>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="block-2 teal">
              <span class="wrap-icon">
                <span>3</span>
              </span>
              <h2>Daftarkan PKM yang anda pilih</h2>
              <p>Ketua Kelompok mendaftarkan PKM yg dipilih</p>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="block-2 red">
              <span class="wrap-icon">
                <span>4</span>
              </span>
              <h2>Bimbingan ke Dosen Pembimbing</h2>
              <p>Lakukan Bimbingan dengan Dosen Pembimbing</p>
            </div>
          </div>
        </div>
      </div>
    </div>




    <div class="site-section bg-info">
      <div class="container">
        <div class="row mb-5">
          <div class="col-12 text-center">
            <h2 class="text-white">Jenis-jenis PKM</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="package text-center bg-white">
              <span class="img-wrap"><img src="assets/img/PKM-P.png" alt="Image" class="img-fluid"></span>
              <h3 class="text-teal">PKM-P</h3>
              <p>Bertujuan untuk mengungkap hubungan sebab-akibat, aksi-reaksi, rancang bangun, perilaku sosial, ekonomi, pendidikan, kesehatan atau budaya baik dalam aspek eksperimental maupun deskriptif</p><br><br>
              <p><a href="/download/template/PKM-P" class="btn btn-primary btn-custom-1 mt-4" target="_blank">Download Template</a></p>
            </div>
          </div>
          <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="package text-center bg-white">
              <span class="img-wrap"><img src="assets/img/PKM-K.png" alt="Image" class="img-fluid"></span>
              <h3 class="text-success">PKM-K</h3>
              <p>Bertujuan untuk menumbuhkan pemahaman dan keterampilan mahasiswa dalam menghasilkan komoditas unik serta merintis kewirausahaan yang berorientasi pada profit</p><br><br>
              <p><a href="/download/template/PKM-K" class="btn btn-warning btn-custom-1 mt-4" target="_blank">Download Template</a></p>
            </div>
          </div>
          <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="package text-center bg-white">
              <span class="img-wrap"><img src="assets/img/PKM-M.png" alt="Image" class="img-fluid"></span>
              <h3 class="text-danger">PKM-M</h3>
              <p>Bertujuan untuk menumbuhkan empati mahasiswa kepada persoalan yang dihadapi masyarakat melalui penerapan iptek kampus yang menjadi solusi tepat bagi persoalan atau kebutuhan masyarakat yang tidak berorientasi pada profit</p>
              <p><a href="/download/template/PKM-M" class="btn btn-success btn-custom-1 mt-4" target="_blank">Download Template</a></p>
            </div>
          </div>
        </div>
        <br><br>
        <div class="row justify-content-md-center">
          <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="package text-center bg-white">
              <span class="img-wrap"><img src="assets/img/PKM-T.png" alt="Image" class="img-fluid"></span>
              <h3 class="text-danger">PKM-T</h3>
              <p>Bertujuan untuk membuka wawasan iptek mahasiswa terhadap persoalan yang dihadapi dunia usaha (usaha mikro sampai perusahaan besar) atau masyarakat yang berorientasi pada profit</p><br>
              <p><a href="/download/template/PKM-T" class="btn btn-success btn-custom-1 mt-4" target="_blank">Download Template</a></p>
            </div>
          </div>

          <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="package text-center bg-white">
              <span class="img-wrap"><img src="assets/img/PKM-KC.png" alt="Image" class="img-fluid"></span>
              <h3 class="text-danger">PKM-KC</h3>
              <p>Bertujuan membentuk kemampuan mahasiswa mengkreasikan sesuatu yang baru dan fungsional atas dasar karsa dan nalarnya. Karya cipta tersebut bisa saja belum memberikan kemanfaatan langsung bagi pihak lain</p>
              <p><a href="/download/template/PKM-KC" class="btn btn-success btn-custom-1 mt-4" target="_blank">Download Template</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <center>
              <h2 class="text-black">Tahapan PKM</h2>
            </center>
          </div>
          <div class="col-md-12">
            <center><img src="assets/img/alur.jpg" alt="Image" height="400px"></center>
          </div>
        </div>
      </div>
    </div>
    <footer class="site-footer">
      <div class="container">
        <div class="row text-center">
          <div class="col-md-12">
            <p>
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
              Copyright &copy;<script>
                document.write(new Date().getFullYear());
              </script> All rights reserved | PKM APPS is made with <i class="icon-heart text-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Kesi</a>
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </p>
          </div>

        </div>
      </div>
    </footer>

  </div>

  <script src="{{ asset('js/dashboard.js') }}" type="text/javascript"></script>
  <script src="{{ asset('vendor/kiddy/js/main.js') }}" type="text/javascript"></script>

</body>

</html>