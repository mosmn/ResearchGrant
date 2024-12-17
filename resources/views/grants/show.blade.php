@extends('layouts.app')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('grants.index') }}">Research Grants</a></li>
<li class="breadcrumb-item active">{{ $grant->title }}</li>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Research Grant Details</span>
                    @can('admin-executive')
                        <div>
                            <a href="{{ route('grants.edit', $grant) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('grants.destroy', $grant) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </div>
                    @endcan
                </div>

                <div class="card-body">
                    <div class="mb-4">
                        <h5>Title</h5>
                        <p>{{ $grant->title }}</p>
                    </div>

                    <div class="mb-4">
                        <h5>Grant Amount</h5>
                        <p>RM {{ number_format($grant->grant_amount, 2) }}</p>
                    </div>

                    <div class="mb-4">
                        <h5>Grant Provider</h5>
                        <p>{{ $grant->grant_provider }}</p>
                    </div>

                    <div class="mb-4">
                        <h5>Duration</h5>
                        <p>{{ $grant->duration }} months</p>
                    </div>

                    <div class="mb-4">
                        <h5>Project Leader</h5>
                        <p>{{ $grant->projectLeader->name }}</p>
                    </div>

                    <div class="mb-4">
                        <h5>Team Members</h5>
                        <ul class="list-unstyled">
                            @foreach($grant->teamMembers as $member)
                                <li>{{ $member->name }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div>
                        <h5>Milestones</h5>
                        <ul class="list-unstyled">
                            @foreach($grant->milestones as $milestone)
                                <li class="mb-2">
                                    <strong>{{ $milestone->title }}</strong><br>
                                    Due: {{ $milestone->due_date }}
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('grants.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>
            </div>

            @can('manage-members', $grant)
            <div class="card">
                <div class="card-header">Manage Team Members</div>
                <div class="card-body">
                    <form action="{{ route('grants.members.update', $grant) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Select Team Members</label>
                            <select name="member_ids[]" class="form-select" multiple>
                                @foreach($availableAcademicians as $academician)
                                    <option value="{{ $academician->id }}"
                                        {{ $grant->teamMembers->contains($academician->id) ? 'selected' : '' }}>
                                        {{ $academician->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Team Members</button>
                    </form>
                </div>
            </div>
            @endcan

            @can('manage-milestones', $grant)
            <div class="card mt-4">
                <div class="card-header">Manage Milestones</div>
                <div class="card-body">
                    <form action="{{ route('milestones.store', $grant) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="name" class="form-control" placeholder="Milestone Name" required>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="deliverable" class="form-control" placeholder="Deliverable" required>
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="target_completion_date" class="form-control" required>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </form>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Deliverable</th>
                                <th>Target Date</th>
                                <th>Status</th>
                                <th>Last Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grant->milestones as $milestone)
                            <tr>
                                <td>{{ $milestone->name }}</td>
                                <td>{{ $milestone->deliverable }}</td>
                                <td>{{ $milestone->target_completion_date }}</td>
                                <td>
                                    <form action="{{ route('milestones.update', [$grant, $milestone]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-2">
                                            <select name="status" class="form-select">
                                                <option value="pending" {{ $milestone->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="in progress" {{ $milestone->status === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                                <option value="completed" {{ $milestone->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <textarea name="remark" class="form-control" placeholder="Add remarks">{{ $milestone->remark }}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                    </form>
                                </td>
                                <td>{{ $milestone->updated_at->format('Y-m-d') }}</td>
                                <td>
                                    <form action="{{ route('milestones.destroy', [$grant, $milestone]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endcan
        </div>
    </div>
</div>
@endsection
