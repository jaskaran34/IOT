@extends('app')

@section('title', 'Module Status')

@section('content')

<div class="container">
    <h3>Module Status Dashboard</h3>

    <!-- Total Modules, Active Modules, and Inactive Modules Counts -->
    
    <!-- Dropdown for Module Selection -->
    <div class="mt-4">
        <h4>Select Module to View Status</h4>
        <form action="" method="GET" id="moduleStatusForm">
            <div class="form-group">
                <label for="module">Module Name</label>
                <select id="module" name="module_id" class="form-control" onchange="fetchModuleStatus()">
                    <option value="">Select Module</option>
                    @foreach($modules as $module)
                        <option value="{{ $module->id }}">{{ $module->name }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    <!-- Status Monitorings Table -->
    <div class="mt-4">
        <h4>Status Monitorings</h4>
        <table class="table table-bordered" id="statusMonitoringTable">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Time in Status</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated dynamically via JavaScript -->
            </tbody>
        </table>
    </div>
</div>

@endsection

<script>

function fetchModuleStatus() {
    var moduleId = document.getElementById('module').value;

    if (moduleId) {
        fetch(`/module-status/${moduleId}`)
            .then(response => response.json())
            .then(data => {
                var tableBody = document.getElementById('statusMonitoringTable').getElementsByTagName('tbody')[0];
                tableBody.innerHTML = ''; // Clear previous data

                data.forEach(function(status) {
                    var row = tableBody.insertRow();
                    var statusCell = row.insertCell(0);
                    var timeInStatusCell = row.insertCell(1);
                    var createdAtCell = row.insertCell(2);

                    // Populate each cell with the respective status data
                    statusCell.textContent = status.status;
                    timeInStatusCell.textContent = status.time_in_status || 'N/A';
                    createdAtCell.textContent = new Date(status.created_at).toLocaleString(); // Formatting the created_at timestamp
                });
            })
            .catch(error => console.error('Error fetching module status:', error));
    } else {
        // Clear table if no module is selected
        var tableBody = document.getElementById('statusMonitoringTable').getElementsByTagName('tbody')[0];
        tableBody.innerHTML = '';
    }
}


</script>

