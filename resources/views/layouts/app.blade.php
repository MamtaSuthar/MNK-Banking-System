<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
 
   @include('includes.header')
    
</head>
<body>
    <div id="app">
          <!-- Navbar -->
         
         @include('includes.navbar')
      

        <div class="container mt-4">
            <div class="row">
                <!-- Sidebar -->
            @if(Auth::user() != null)
              @include('includes.sidebar')
            @else
            <div class="col-md-1">
            </div>
            @endif
                <!-- Main Content -->
                <main class="col-md-9">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <!-- Scripts -->
   @include('includes.footer')
   @yield('custome-script')
</body>
</html>
