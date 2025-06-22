@extends('layouts.app')

@section('title', 'Branch Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="page-title">Branch Management</h4>
    </div>

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
                        <th>Franchisee</th>
                        <th>Email</th>
                        <th>Contact</th>
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
                            <td>{{ $branch['franchisee_name'] }}</td>
                            <td>{{ $branch['email_address'] }}</td>
                            <td>{{ $branch['contact_number'] }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ url('/branches/' . $branch['id'] . '/view') }}" class="btn btn-sm btn-outline-primary">View</a>
                                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Performance Summary</a></li>
                                        <li><a class="dropdown-item" href="#">Commission Records</a></li>
                                        <li><a class="dropdown-item" href="#">Inventory Status</a></li>
                                    </ul>
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
