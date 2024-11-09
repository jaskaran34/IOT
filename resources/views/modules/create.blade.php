@extends('app')

@section('title', 'Module Add')

@section('content')


<div class="container">
    <h2>Modules</h2>
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
<form action="{{ route('modules.store') }}" method="POST" class="p-4 border rounded bg-light">
    @csrf
    <div class="form-group">
        <label for="name">Module Name:</label>
        <input type="text" id="name" name="name" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="type">Measurement Type:</label>
        <select id="measurement_type" name="measurement_type_id" class="form-control" required>
            <option value="#">Select</option>
            @foreach($measurementTypes as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary mt-2">Register Module</button>
</form>

    <div class="card">
        <div class="card-header">List of Module</div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Measurement Type</th>
                        <th>Status</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                     $counter=1;
                    ?>
                @foreach ($modules as $module) 
                <tr>
                <form action="{{ route('modules.update', $module['id']) }}" method="POST" style="display: flex;">
                @csrf 

                <td>{{ $counter}}</td>
                 <td><input type="text" name="name" value="{{ $module['name'] }}" class="form-control" required> </td>
                  <td>

                  <select  name="measurement_type_id" class="form-control"  required> 
                   @foreach($measurementTypes as $type) 
                   <option value="{{ $type->id }}" {{ $module['measurement_type_id'] == $type->id ? 'selected' : '' }}> {{ $type->name }} </option> 
                  @endforeach </select>
                  </td>
                  <td>
                  <select  name="status" class="form-control"  required>  
                  <option value="active" {{ 'active' == $module['status'] ? 'selected' : '' }}> active  </option>
                  <option value="inactive" {{ 'inactive' == $module['status'] ? 'selected' : '' }}> inactive </option>  
                </select> 
                  </td>
                  <td><button type="submit" class="btn btn-primary ms-2">Update</button>
                            </form></td>
    
                  <td>{{ \Carbon\Carbon::parse($module['updated_at'])->diffForHumans() }}</td>
                  <td>
                                <!-- Delete Button -->
                                <form action="{{ route('module.destroy', $module['id']) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this module ?')">Delete</button>
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

<script type="text/javascript">
    
    
</script>