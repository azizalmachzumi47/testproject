<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap CSS -->
  <link rel="shortcut icon" href="{{ asset('favicon_pstechno.png') }}" type="image/x-icon" />
  <link rel="stylesheet" href="{{asset('assetsapp/vendor/bootstrap/css/bootstrap.min.css')}}">
  <link href="{{asset('assetsapp/vendor/fonts/circular-std/style.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('assetsapp/libs/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('assetsapp/vendor/fonts/fontawesome/css/fontawesome-all.css')}}">
  <link rel="stylesheet" href="{{asset('assetsapp/vendor/charts/chartist-bundle/chartist.css')}}">
  <link rel="stylesheet" href="{{asset('assetsapp/vendor/charts/morris-bundle/morris.css')}}">
  <link rel="stylesheet"
    href="{{asset('assetsapp/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('assetsapp/vendor/charts/c3charts/c3.css')}}">
  <link rel="stylesheet" href="{{asset('assetsapp/vendor/fonts/flag-icon-css/flag-icon.min.css')}}">
  <link rel="stylesheet" href="{{asset('assetsapp/vendor/fonts/fontawesome/css/fontawesome-all.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('assetsapp/vendor/datatables/css/dataTables.bootstrap4.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('assetsapp/vendor/datatables/css/buttons.bootstrap4.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('assetsapp/vendor/datatables/css/select.bootstrap4.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('assetsapp/vendor/datatables/css/fixedHeader.bootstrap4.css')}}">
  <!-- SweetAlert2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.28/dist/sweetalert2.min.css" rel="stylesheet">

  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.28/dist/sweetalert2.all.min.js"></script>

  <title>@yield('title', 'Dashboard')</title>
</head>

<body>

  <div class="dashboard-main-wrapper">

    <div class="dashboard-header">
      @include('partials.navbar')
    </div>

    <div class="nav-left-sidebar sidebar-dark">
      @include('partials.sidebar')
    </div>

    <div class="dashboard-wrapper">
      <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">

          <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
              <div class="page-header">
                @yield('content')
              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- Modal Logout -->
      <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Apakah Anda yakin ingin logout?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
              <!-- Form Logout -->
              <form action="{{ route('logout') }}" method="POST" style="display: inline">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="footer">
        <div class="container-fluid">
          <div class="row">
            <span style="display: inline-flex; align-items: center; gap: 10px;">
              <img src="{{asset('favicon_pstechno.png')}}" alt="Logo PSTECHNO" style="width: 150px; height: auto;"
                class="light-logo" />
              PSTECHNO | ᮕᮥᮒᮁᮃ ᮞᮤᮜᮤᮝᮃᮍᮤ ᮒᮨᮎ᮪ᮂᮔᮧᮜᮧᮌ᮪ᮚ᮪ | <?= date('Y'); ?> .
            </span>
          </div>
        </div>
      </div>

    </div>

  </div>

  <!-- Optional JavaScript -->
  <!-- jquery 3.3.1 -->
  <script src="{{asset('assetsapp/vendor/jquery/jquery-3.3.1.min.js')}}"></script>
  <!-- bootstap bundle js -->
  <script src="{{asset('assetsapp/vendor/bootstrap/js/bootstrap.bundle.js')}}"></script>
  <!-- slimscroll js -->
  <script src="{{asset('assetsapp/vendor/slimscroll/jquery.slimscroll.js')}}"></script>
  <!-- main js -->
  <script src="{{asset('assetsapp/libs/js/main-js.js')}}"></script>
  <!-- chart chartist js -->
  <script src="{{asset('assetsapp/vendor/charts/chartist-bundle/chartist.min.js')}}"></script>
  <!-- sparkline js -->
  <script src="{{asset('assetsapp/vendor/charts/sparkline/jquery.sparkline.js')}}"></script>
  <!-- morris js -->
  <script src="{{asset('assetsapp/vendor/charts/morris-bundle/raphael.min.js')}}"></script>
  <script src="{{asset('assetsapp/vendor/charts/morris-bundle/morris.js')}}"></script>
  <!-- chart c3 js -->
  <script src="{{asset('assetsapp/vendor/charts/c3charts/c3.min.js')}}"></script>
  <script src="{{asset('assetsapp/vendor/charts/c3charts/d3-5.4.0.min.js')}}"></script>
  <script src="{{asset('assetsapp/vendor/charts/c3charts/C3chartjs.js')}}"></script>
  <script src="{{asset('assetsapp/libs/js/dashboard-ecommerce.js')}}"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="{{asset('assetsapp/vendor/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="{{asset('assetsapp/vendor/datatables/js/buttons.bootstrap4.min.js')}}"></script>
  <script src="{{asset('assetsapp/vendor/datatables/js/data-table.js')}}"></script>
  <script src="{{asset('js/app.js')}}"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
            });
        @endif

        @if($errors->any())
            let errorMessages = '';
            @foreach ($errors->all() as $error)
                errorMessages += '{{ $error }}\n';
            @endforeach
            Swal.fire({
                icon: 'error',
                title: 'Validation Errors',
                text: errorMessages,
            });
        @endif
    });
  </script>

  <script>
    $(document).ready(function() {
        $('.form-check-input').on('click', function() {
            const menuId = $(this).data('menu');
            const roleId = $(this).data('role');

            $.ajax({
                url: "{{ route('admin.changeAccess') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    menuId: menuId,
                    roleId: roleId
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Akses berhasil diperbarui',
                            timer: 2000, // Menutup otomatis setelah 2 detik
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Gagal memperbarui akses',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan!',
                        text: 'Terjadi kesalahan pada server',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        });
    });
  </script>

</body>

</html>
