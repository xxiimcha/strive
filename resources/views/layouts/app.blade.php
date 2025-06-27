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
        <div class="page-content"> {{-- Add vertical spacing --}}
            <div class="container-fluid">

                {{-- Page Title and Breadcrumb (Optional: Show only when section is defined) --}}
                @hasSection('page-header')
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <div class="page-title-box d-md-flex justify-content-between align-items-center">
                                <h4 class="page-title">@yield('page-header')</h4>
                                <div>
                                    <ol class="breadcrumb mb-0">
                                        @yield('breadcrumb')
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Page Content --}}
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
