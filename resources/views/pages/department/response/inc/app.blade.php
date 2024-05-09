<!DOCTYPE html>
<html lang="en">

<head>
    @yield('title')
</head>

<body class="sidebar-collapse layout-top-nav layout-footer-fixed">
<div class="wrapper">
    <header id="header" class="absolute-top d-flex align-items-center">
        <div class="container">
            <div class="header-container d-flex align-items-center justify-content-between">
                <div class="logo">
                    <h2 class="text-info"><span>{{ env('APP_NAME') }}</span></h2>
                </div>

                <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
                    <div class="logo">
                        
            
                        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                            <ul class="navbar-nav">
            
                            </ul>
                        </div>
            
                        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    @yield('content')
    @include('layout.footer')
</div>

@include('layout.script')
@stack('script')
</body>

</html>
