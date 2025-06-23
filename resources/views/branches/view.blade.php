@extends('layouts.app')

@section('title', 'Branch Details')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Branch Details</h4>
        <a href="{{ route('branches.index') }}" class="btn btn-outline-secondary">← Back to Branch List</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-1"><strong>Branch Code:</strong></p>
                    <p class="text-muted">{{ $branch['branch_code'] }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong>Branch Name:</strong></p>
                    <p class="text-muted">{{ $branch['branch'] }}</p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-1"><strong>Region:</strong></p>
                    <p class="text-muted">{{ $branch['region'] }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong>Location:</strong></p>
                    <p class="text-muted">{{ $branch['location'] }}</p>
                </div>
            </div>

            <hr>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-1"><strong>Franchisee Name:</strong></p>
                    <p class="text-muted">{{ $branch['franchisee_name'] }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong>Email Address:</strong></p>
                    <p class="text-muted">{{ $branch['email_address'] }}</p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-1"><strong>Contact Number:</strong></p>
                    <p class="text-muted">{{ $branch['contact_number'] }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong>Status:</strong></p>
                    <span class="badge bg-{{ $branch['status'] === 'Active' ? 'success' : ($branch['status'] === 'Inactive' ? 'secondary' : 'warning') }}">
                        {{ $branch['status'] ?? 'Not Activated' }}
                    </span>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6">
                    <p class="mb-1"><strong>Franchise Date:</strong></p>
                    <p class="text-muted">{{ \Carbon\Carbon::parse($branch['franchise_date'])->format('F d, Y') }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong>End of Contract:</strong></p>
                    <p class="text-muted">{{ \Carbon\Carbon::parse($branch['end_of_contract'])->format('F d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
