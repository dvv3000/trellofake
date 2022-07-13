<!--
=========================================================
* Material Dashboard 2 - v=3.0.2
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{-- <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png"> --}}
    {{-- <link rel="icon" type="image/png" href="./assets/img/favicon.png"> --}}
    <title>
        {{ config('app.name') }}
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/nucleo-svg.css') }}" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/93209c9eea.js" crossorigin="anonymous"></script>

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('css/material-dashboard.css?v=3.0.2') }}" rel="stylesheet" />


    @stack('css')
</head>


<body class="g-sidenav-show  bg-gray-200">
    @include('layout.sidebar')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        @include('layout.navbar')

        <!-- Content -->

        @yield('content')

        <!-- End content -->
    </main>


    <!--   Core JS Files   -->
    <script src="{{ asset('js/core/popper.min.js') }}"></script>
    <script src="{{ asset('js/core/bootstrap.min.js') }}"></script>

    <script src="{{ asset('js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/plugins/smooth-scrollbar.min.js') }}"></script>


    <!-- Github buttons -->
    {{-- <script async defer src="https://buttons.github.io/buttons.js"></script> --}}
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    {{-- <script src="{{ asset('js/material-dashboard.min.js?v=3.0.2')}}"></script> --}}

    <script>
        let sidebar = document.querySelector('.navbar-nav')
        let sidebarBtns = sidebar.querySelectorAll('.nav-link')

        for (var i = 0; i < sidebarBtns.length; i++) {
            sidebarBtns[i].addEventListener("click", function() {
                let current = sidebar.querySelector('.active')
                current.classList.remove('bg-gradient-primary', 'active')
                this.classList.add('bg-gradient-primary', 'active')
            })
        }

        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }

        // Chinh active cho sidebar
        let pathArray = window.location.pathname.split('/')
        if (pathArray[1] === '') {
            sidebar.querySelector('#dashboard').classList.add('bg-gradient-primary', 'active')
            document.querySelector('.parent1').innerHTML = 'Dashboard'
        } else {
            sidebar.querySelector(`#${pathArray[1]}`).classList.add('bg-gradient-primary', 'active')
            document.querySelector('.parent1').innerHTML = capitalizeFirstLetter(pathArray[1])

        }

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    </script>


    @stack('js')
</body>

</html>
