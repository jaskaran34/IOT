@extends('app')

@section('content')
<div class="container mt-4">
    <h2>Module Types</h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
    @endif

    <!-- Form to Add New Module Type -->
    <div class="card mb-4">
        <div class="card-header">Add New Module Type</div>
        <div class="card-body">
            <form action="{{ route('module-types.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Module Type Name</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Type</button>
            </form>
        </div>
    </div>

    <!-- Table to List Module Types -->
    <div class="card">
        <div class="card-header">List of Module Types</div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Module types</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($types as $type)
                        <tr>
                            <td>{{ $type->id }}</td>
                            <td>{{ $type->name }}</td>
                            <td>{{ $type->created_at->format('Y-m-d') }}</td>
                            <td>
                                <!-- Delete Button -->
                                <form action="{{ route('module-types.destroy', $type->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this module type?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
