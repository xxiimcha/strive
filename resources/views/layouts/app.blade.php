<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
<head>
    @include('layouts.partials.head')
    <title>@yield('title', 'Dashboard') | Strive</title>
</head>
<body>

    {{-- Top Navigation --}}
    @include('layouts.partials.topbar')

    {{-- Sidebar Navigation --}}
    @include('layouts.partials.sidebar')

    <div class="page-wrapper">
        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>

    {{-- Footer --}}
    @include('layouts.partials.footer')

    {{-- Scripts --}}
    @include('layouts.partials.scripts')
</body>
</html>
