@extends('app')

@section('content')
<div class="container">
    <h2>Skipped Modules Details</h2>

    @if($skippedModules->isEmpty())
        <p>No skipped modules recorded.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Module ID</th>
                    <th>Failure Time</th>
                    <th>Additional Information</th>
                </tr>
            </thead>
            <tbody>
                @foreach($skippedModules as $module)
                    <tr>
                        <td>{{ $module->module_id }}</td>
                        <td>{{ $module->skipped_at }}</td>
                        <td>{{ $module->reason }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">Back to Dashboard</a>
</div>
@endsection
