@extends('app')

@section('content')
<div class="container">
<meta name="csrf-token" content="{{ csrf_token() }}">

<h2>Skipped Modules Details</h2>

    @if($skippedModules->isEmpty())
        <p>No record.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Module ID</th>
                    <th>Failure Time</th>
                    <th>Additional Information</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($skippedModules as $module)
                    <tr>
                        <td>{{ $module->module_id }}</td>
                        <td>{{ $module->skipped_at }}</td>
                        <td>{{ $module->reason }}</td>
                        <td>
                        <div>
        <span>{{ $module->name }}</span>
        <a href="{{ route('skippedModules.updateStatus', ['id' => $module->id, 'status' => 'resolved']) }}" class="btn btn-success">Resolve</a>
        <a href="{{ route('skippedModules.updateStatus', ['id' => $module->id, 'status' => 'ignored']) }}" class="btn btn-warning">Ignore</a>
    </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">Back to Dashboard</a>
</div>

<script>
    
        
    
</script>


@endsection


