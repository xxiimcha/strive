@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-md-flex justify-content-between align-items-center">
            <h4 class="page-title">Branch Dashboard</h4>
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="#">Strive</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <!-- Total Revenue -->
    <div class="col-md-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0 bg-primary-subtle text-primary thumb-md rounded-circle">
                        <i class="iconoir-dollar-circle fs-4"></i>
                    </div>
                    <div class="flex-grow-1 ms-2 text-truncate">
                        <p class="text-dark mb-0 fw-semibold fs-14">Total Revenue</p>
                        <p class="mb-0 text-truncate text-muted"><span class="text-success">↑</span> From last week</p>
                    </div>
                </div>
                <h3 class="fw-bold">₱{{ number_format(8365, 2) }}</h3>
            </div>
        </div>
    </div>

    <!-- New Clients -->
    <div class="col-md-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0 bg-info-subtle text-info thumb-md rounded-circle">
                        <i class="iconoir-user-square fs-4"></i>
                    </div>
                    <div class="flex-grow-1 ms-2 text-truncate">
                        <p class="text-dark mb-0 fw-semibold fs-14">New Clients</p>
                        <p class="mb-0 text-truncate text-muted"><span class="text-success">↑</span> Compared to last month</p>
                    </div>
                </div>
                <h3 class="fw-bold">124</h3>
            </div>
        </div>
    </div>

    <!-- Services Rendered -->
    <div class="col-md-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0 bg-warning-subtle text-warning thumb-md rounded-circle">
                        <i class="iconoir-cut-alt fs-4"></i>
                    </div>
                    <div class="flex-grow-1 ms-2 text-truncate">
                        <p class="text-dark mb-0 fw-semibold fs-14">Services Today</p>
                        <p class="mb-0 text-truncate text-muted"><span class="text-danger">↓</span> From yesterday</p>
                    </div>
                </div>
                <h3 class="fw-bold">57</h3>
            </div>
        </div>
    </div>

    <!-- Products Used -->
    <div class="col-md-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0 bg-danger-subtle text-danger thumb-md rounded-circle">
                        <i class="iconoir-box fs-4"></i>
                    </div>
                    <div class="flex-grow-1 ms-2 text-truncate">
                        <p class="text-dark mb-0 fw-semibold fs-14">Products Used</p>
                        <p class="mb-0 text-truncate text-muted">Inventory consumption</p>
                    </div>
                </div>
                <h3 class="fw-bold">89</h3>
            </div>
        </div>
    </div>
</div>

<!-- Placeholder for charts or tables -->
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Monthly Sales Overview</h4>
                <small class="text-muted">This chart is placeholder</small>
            </div>
            <div class="card-body">
                <div id="monthly-sales" class="apex-charts" style="min-height: 300px;"></div>
            </div>
        </div>
    </div>
</div>
@endsection
