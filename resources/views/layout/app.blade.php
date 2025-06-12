<!doctype html>
<html lang="ar" data-bs-theme="light_mode" dir="rtl">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
@stack('script')
@stack('scripts')
  <title>خدمه من هنا</title>
  <!--favicon-->
  <link rel="icon" href="assets/images/logo1.png" type="image/png">
  <!-- loader-->
  <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet">
  <script src="{{ asset('assets/js/pace.min.js') }}"></script>
  
  <!-- plugins -->
  <link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/metismenu/metisMenu.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/metismenu/mm-vertical.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}">
  
  <!--bootstrap css-->
  <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
    integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
  <!-- main css -->
  <link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
  <link href="{{ asset('sass/main.css') }}" rel="stylesheet">
  <link href="{{ asset('sass/dark-theme.css') }}" rel="stylesheet">
  <link href="{{ asset('sass/blue-theme.css') }}" rel="stylesheet">
  <link href="{{ asset('sass/semi-dark.css') }}" rel="stylesheet">
  <link href="{{ asset('sass/bordered-theme.css') }}" rel="stylesheet">
  <link href="{{ asset('sass/responsive.css') }}" rel="stylesheet">
  <link href="{{ asset('sass/select.css') }}" rel="stylesheet">
  
</head>

<body>

  <!--start header-->
  <header class="top-header">
    <nav class="navbar navbar-expand d-flex align-items-center justify-content-between">
      <div class="btn-toggle">
        <a href="javascript:;"><i class="material-icons-outlined">menu</i></a>
      </div>
      <div class="card-body search-content text-center">
        <h1 style="color: #025e6e;"></h1>
      </div>
      <ul class="navbar-nav gap-1 nav-right-links align-items-center">
        <li class="nav-item dropdown">
          <div class="dropdown-menu dropdown-notify dropdown-menu-end shadow">
            <div class="notify-list">
            </div>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a href="javascrpt:;" class="dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
            <img src="assets/images/logo1.png" class="rounded-circle p-1 border" width="45" height="45" alt="">
          </a>
          <div class="dropdown-menu dropdown-user dropdown-menu-start shadow">
            <a class="dropdown-item  gap-2 py-2" href="javascript:;">
              <div class="text-center">
                <img src="assets/images/logo1.png" class="rounded-circle p-1 shadow mb-3" width="90" height="90" alt="">
                <h5 class="user-name mb-0 fw-bold">خدمة من هنا</h5>
              </div>
            </a>
            <hr class="dropdown-divider">
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
              @csrf
              <button type="submit" class="dropdown-item d-flex align-items-center gap-2 py-2">
                  <i class="material-icons-outlined">power_settings_new</i>تسجيل خروج
              </button>
          </form>
          
          </div>
        </li>
      </ul>

    </nav>
  </header>
  <!--end top header-->

  <!--start sidebar-->
  @include('layout.sidebar')



  <!--end sidebar-->

  @yield('content')

 <!--start overlay-->
 <div class="overlay btn-toggle"></div>
 <!--end overlay-->




 <style>
  
   .nav-link.active {
     background-color: #30B0C7 !important; 
     color: white !important; 
     border-radius: 5px; 
   }
 
   
   .nav-link.active .parent-icon i,
   .nav-link.active .menu-title {
     color: white;
   }
 
  
   .nav-link:hover {
     background-color: #dbe8ff!important; 
     color: #30B0C7!important;
     border-radius: 5px;
   }
 
   .nav-link:hover .parent-icon i,
   .nav-link:hover .menu-title {
     color: #30B0C7;
   }
 </style>
   <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
 <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <!-- JavaScript files -->
  <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/js/metisMenu.min.js') }}"></script>
  <script src="{{ asset('assets/js/select.js') }}"></script>

  <script src="{{ asset('assets/js/simplebar.min.js') }}"></script>
  <script src="{{ asset('assets/js/main.js') }}"></script>

<!--plugins-->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<!--plugins-->
<script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "اختر مركزًا أو محافظة",
            allowClear: true,
            width: '100%'
        });
    });
</script>

<!--<script src="{{ asset('assets/js/select.js') }}"></script>-->

<!--<script src="{{ asset('assets/js/main.js') }}"></script>-->

@yield('scripts')
</body>

</html>

</html>