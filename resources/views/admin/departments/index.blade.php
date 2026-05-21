@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Manage Departments</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <h5>Add New Department</h5>
            <form action="{{ route('admin.departments.store') }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" name="name" class="form-control" placeholder="Department Name" required>
                    <button type="submit" class="btn btn-primary">Add Department</button>
                </div>
            </form>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Department Name</th>
                <th>Staff Assigned</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departments as $dept)
            <tr>
                <td>{{ $dept->name }}</td>
                <td>{{ $dept->users_count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection