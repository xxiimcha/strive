@extends('layouts.app')

@section('title', 'Service Transactions')

@section('page-header', 'Service Transactions')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Strive</a></li>
    <li class="breadcrumb-item"><a href="#">Modules</a></li>
    <li class="breadcrumb-item active">Service Transactions</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-body pt-0">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive mt-3">
                    <table class="table datatable" id="datatable_1">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>OR#</th>
                                <th>SS#</th>
                                <th>Services Availed</th>
                                <th>Total Amount</th>
                                <th>Individual Staff</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $tx)
                                <tr>
                                    <td>{{ $tx['date'] }}</td>
                                    <td><span class="badge bg-soft-info text-dark">{{ $tx['or_number'] }}</span></td>
                                    <td><span class="badge bg-soft-dark text-white">{{ $tx['ss_number'] }}</span></td>
                                    <td class="text-start">{{ $tx['services'] }}</td>
                                    <td class="fw-bold text-end text-success">₱{{ number_format($tx['amount'], 2) }}</td>
                                    <td>
                                        @foreach($tx['staff_services'] as $pair)
                                            <span class="badge bg-soft-secondary">{{ $pair['staff'] }}: {{ $pair['service'] }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewModal{{ $loop->index }}">
                                            View
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="viewModal{{ $loop->index }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $loop->index }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title" id="viewModalLabel{{ $loop->index }}">Service Invoice</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Invoice Header -->
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <h6><strong>Invoice Date:</strong> {{ $tx['date'] }}</h6>
                                                                <h6><strong>OR Number:</strong> {{ $tx['or_number'] }}</h6>
                                                                <h6><strong>SS Number:</strong> {{ $tx['ss_number'] }}</h6>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                <h6><strong>Customer Name:</strong> {{ $tx['customer_name'] ?? 'N/A' }}</h6>
                                                                <h6><strong>Contact Number:</strong> {{ $tx['customer_contact'] ?? 'N/A' }}</h6>
                                                            </div>
                                                        </div>

                                                        <hr>

                                                        <!-- Services Table -->
                                                        <h6 class="mb-3">Services Rendered</h6>
                                                        <table class="table table-bordered">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>Staff</th>
                                                                    <th>Service</th>
                                                                    <th>Rate</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($tx['staff_services'] as $pair)
                                                                    <tr>
                                                                        <td>{{ $pair['staff'] }}</td>
                                                                        <td>{{ $pair['service'] }}</td>
                                                                        <td>₱{{ number_format($pair['rate'], 2) }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>

                                                        <div class="text-end mt-4">
                                                            <h5 class="fw-bold">Total: ₱{{ number_format($tx['amount'], 2) }}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No service transactions found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div><!-- card-body -->
        </div><!-- card -->
    </div><!-- col -->
</div><!-- row -->
@endsection
