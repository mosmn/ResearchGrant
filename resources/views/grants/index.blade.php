
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Research Grants</span>
                    @can('admin-executive')
                        <a href="{{ route('grants.create') }}" class="btn btn-primary">Add New Grant</a>
                    @endcan
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Amount</th>
                                    <th>Provider</th>
                                    <th>Duration (months)</th>
                                    <th>Project Leader</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($grants as $grant)
                                <tr>
                                    <td>{{ $grant->title }}</td>
                                    <td>RM {{ number_format($grant->grant_amount, 2) }}</td>
                                    <td>{{ $grant->grant_provider }}</td>
                                    <td>{{ $grant->duration }}</td>
                                    <td>{{ $grant->projectLeader->name }}</td>
                                    <td class="d-flex gap-2">
                                        <a href="{{ route('grants.show', $grant) }}" class="btn btn-sm btn-info">View</a>
                                        @can('admin-executive')
                                            <a href="{{ route('grants.edit', $grant) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('grants.destroy', $grant) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $grants->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection