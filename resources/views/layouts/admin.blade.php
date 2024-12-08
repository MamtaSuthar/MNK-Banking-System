<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
 
   @include('includes_admin.header')
    
</head>
<body>
    <div id="app">
          <!-- Navbar -->
        @include('includes_admin.navbar')

        <div class="container mt-4">
            <div class="row">
                <!-- Sidebar -->
              @include('includes_admin.sidebar')

                <!-- Main Content -->
                <main class="col-md-9">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <!-- Scripts -->
   @include('includes_admin.footer')
   @yield('custome-script')
</body>
</html>
