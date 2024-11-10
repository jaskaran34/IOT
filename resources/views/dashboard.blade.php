@extends('app')

@section('title', 'Dashboard')

@section('content')
<div class="container">

<div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Total Modules</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalModules }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Active Modules</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $activeModules }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Inactive Modules</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $inactiveModules }}</h5>
                </div>
            </div>
        </div>
    </div>

    <?php $count=1; ?>
    <div class="row">
        <div class="col-12">
            <div class="card mt-4">
            <div class="card-header">Modules Data</div>
            <div class="card-body">
            <table class="table table-striped">
        <thead>
            <style>
                th{
                    font-size: 14px;
                }
                </style>
            <tr>
                <th>S.no</th>
                <th>Module ID</th>
                <th>Module Name</th>
                <th>Type</th>
                <th>Status</th>
                <th>Data Items Sent</th>
                <th>Current Reading</th>
                <th>Last Reading Time</th>
                <th>Operating Since</th>
                <th>Last Active Since</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($modules as $module)
            <tr>
            <td>{{ $count }}</td>
                <td>{{ $module['id'] }}</td>
                <td>{{ $module['name'] }}</td>
                <td>{{ $module['measurement_type_name'] }}</td>
                <td>{{ $module['status'] }}</td>
                <td>{{ $module['measurements_count'] }}</td>
                <td>{{ $module['last_measurement_value'] }}</td>
                <td>{{ Carbon\Carbon::parse($module['last_measurement_timestamp'])->diffForHumans() }}</td>
                <td>{{ Carbon\Carbon::parse($module['created_at'])->diffForHumans() }}</td>
                <td>{{ $module['status'] == 'active' ? Carbon\Carbon::parse($module['updated_at'])->diffForHumans() : '' }}</td>
                <td><a href="{{ route('module.details', $module['id']) }}" class="btn btn-link">Details</a></td>
            </tr>
            <?php $count++; ?>
            @endforeach
        </tbody>
    </table>
    </div>            
</div>
        </div>
    </div>
    
</div>


@endsection
