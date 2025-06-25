@extends('layouts.app')

@section('title', 'Service Transactions')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Service Transactions</h4>
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">← Back</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle text-center">
            <thead class="table-primary">
                <tr>
                    <th>Date</th>
                    <th>OR#</th>
                    <th>SS#</th>
                    <th>Services Availed</th>
                    <th>Total Amount</th>
                    <th>Individual Staff</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $tx)
                    <tr>
                        <td>{{ $tx['date'] }}</td>
                        <td><span class="badge bg-info text-dark">{{ $tx['or_number'] }}</span></td>
                        <td><span class="badge bg-dark">{{ $tx['ss_number'] }}</span></td>
                        <td class="text-start">{{ $tx['services'] }}</td>
                        <td class="fw-bold text-end text-success">₱{{ number_format($tx['amount'], 2) }}</td>
                        <td>
                            @foreach($tx['staff_services'] as $pair)
                                <span class="badge bg-secondary">{{ $pair['staff'] }}: {{ $pair['service'] }}</span>
                            @endforeach

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-muted">No service transactions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
