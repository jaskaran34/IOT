@extends('app')

@section('title', 'Module Add')

@section('content')
<div class="container">
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

    </div>
   
@endsection

<script type="text/javascript">
    
    
</script>