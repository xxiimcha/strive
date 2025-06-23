@extends('layouts.app')

@section('title', 'Service Transactions')

@section('content')
<div class="container">
    <h4 class="mb-4">Service Transactions</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>Date</th>
                <th>OR#</th>
                <th>SS#</th>
                <th>Services</th>
                <th>Staff(s)</th>
                <th>Amount</th>
                <th>Staff Columns</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $tx)
                <tr>
                    <td>{{ $tx['date'] }}</td>
                    <td>{{ $tx['or_number'] }}</td>
                    <td>{{ $tx['ss_number'] }}</td>
                    <td>{{ $tx['services'] }}</td>
                    <td>{{ $tx['staff_list'] }}</td>
                    <td>₱{{ number_format($tx['amount'], 2) }}</td>
                    <td>
                        @foreach($tx['individual_staff'] as $staff)
                            @if($staff)
                                <span class="badge bg-secondary">{{ $staff }}</span>
                            @endif
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
