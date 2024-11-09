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
    @if(session('info'))
        <div class="alert alert-info">
            {{ session('info') }}
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
                        <th>S.no</th>
                        <th>Module types</th>
                        <th>Updated</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                     $counter=1;
                    ?>
                    @foreach($types as $type)
                    
                        <tr>
                        <form action="{{ route('module-types.update', $type->id) }}" method="POST" style="display: flex;">
                @csrf
                            <td>{{ $counter }}</td>
                            <td><input type="text" name="name" value="{{ $type->name }}" class="form-control" required></td>
                            <td>{{ $type->updated_at->diffForHumans() }}</td>
                            <td><button type="submit" class="btn btn-primary ms-2">Update</button>
                            </form></td>
                            <td>
                                <!-- Delete Button -->
                                <form action="{{ route('module-types.destroy', $type->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this module type?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php $counter++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
