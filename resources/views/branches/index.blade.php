{{-- resources/views/branches/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Branch Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="page-title">Branch Management</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(empty($branches))
        <div class="alert alert-warning">
            No branch data available.
        </div>
    @else
        <div class="table-responsive">
            <table class="table datatable" id="datatable_1">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Branch Code</th>
                        <th>Branch</th>
                        <th>Region</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($branches as $index => $branch)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $branch['branch_code'] }}</td>
                            <td>{{ $branch['branch'] }}</td>
                            <td>{{ $branch['region'] }}</td>
                            <td>{{ $branch['location'] }}</td>

                            <td>
                                <span class="badge bg-{{ $branch['status'] === 'Active' ? 'success' : ($branch['status'] === 'Inactive' ? 'secondary' : 'warning') }}">
                                    {{ $branch['status'] ?? 'Not Activated' }}
                                </span>
                            </td>

                            <td>
                                <div class="btn-group">
                                    <a href="{{ url('/branches/' . $branch['id'] . '/view') }}" class="btn btn-sm btn-outline-primary">View</a>

                                    @if(empty($branch['status']))
                                        <form action="{{ route('branches.activate') }}" method="POST" onsubmit="return confirm('Activate this branch?')">
                                            @csrf
                                            <input type="hidden" name="branch_id" value="{{ $branch['id'] }}">
                                            <button type="submit" class="btn btn-sm btn-outline-success">Activate</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
