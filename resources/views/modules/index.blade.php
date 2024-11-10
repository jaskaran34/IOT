@extends('app')

@section('title', 'Module Status')

@section('content')

<!-- Include Chart.js via CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<div class="container">
    <h4>Module Status Dashboard</h4>

    <!-- Total Modules, Active Modules, and Inactive Modules Counts -->
    
    <!-- Dropdown for Module Selection -->
    <div class="mt-4">
        <h5>Select Module to View Status</h5>
        <form action="" method="GET" id="moduleStatusForm">
            <div class="form-group">
                
                <select id="module" name="module_id" class="form-control" onchange="fetchModuleStatus()">
                    <option value="">Select Module</option>
                    @foreach($modules as $module)
                        <option value="{{ $module->id }}">{{ $module->name }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    
    <style>
    /* Set maximum height for table body and enable scrolling */
    .scrollable-table tbody {
        display: block;
        max-height: 150px; /* Adjust the height as needed */
        overflow-y: scroll;
    }

    .scrollable-table thead, .scrollable-table tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed; /* Ensure the columns align */
    }
</style>

<div class="row mt-2">
    <div class="col-6">
        <div class="card">
            <div class="card-body">
            <div>
<canvas id="lineChart" width="400" height="200"></canvas>
</div>
            </div>
        </div>
    </div>
</div>


    <div class="mt-2">
        <h5>Module Measurement History</h5>
        <table class="table table-bordered scrollable-table" id="measurementTable">
            <thead>
                <tr>
                    <th>Value</th>
                    <th>Reading Type</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated dynamically via JavaScript -->
            </tbody>
        </table>
    </div>


    <!-- Status Monitorings Table -->
    <div class="mt-2">
        <h5>Status Monitorings</h5>
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
    // Declare a variable to hold the chart instance globally
    let lineChart = null;

    // Function to fetch and update the chart data based on selected module
    function updateChart() {
        const moduleId = document.getElementById('module').value;
        
        if (moduleId) {
            fetch(`/module-measurement/${moduleId}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    const labels = data.labels;
                    const values = data.data;

                    // If the chart exists, destroy it before creating a new one
                    if (lineChart) {
                        lineChart.destroy();
                    }

                    // Create the chart using Chart.js
                    const ctx = document.getElementById('lineChart').getContext('2d');
                    lineChart = new Chart(ctx, {
                        type: 'line', // Line chart type
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Measured Value',
                                data: values,
                                borderColor: 'rgba(75, 192, 192, 1)', // Line color
                                borderWidth: 2,
                                fill: false, // Do not fill the area under the line
                                tension: 0.1 // Smoothness of the line
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return `Value: ${tooltipItem.raw}`;
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Time'
                                    },
                                    ticks: {
                                        autoSkip: true,
                                        maxTicksLimit: 20
                                    }
                                },
                                y: {
                                    title: {
                                        display: true,
                                        text: 'Measured Value'
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error fetching module measurements:', error));
        }
    }

function fetchModuleMeasurements() {
    var moduleId = document.getElementById('module').value;

    if (moduleId) {
        fetch(`/module-measurements/${moduleId}`)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                var tableBody = document.getElementById('measurementTable').getElementsByTagName('tbody')[0];
                tableBody.innerHTML = ''; // Clear previous data

                data.forEach(function(measurement) {
                    var row = tableBody.insertRow();
                    var valueCell = row.insertCell(0);
                    var readingTypeCell = row.insertCell(1);
                    var createdAtCell = row.insertCell(2);

                    // Populate each cell with the respective measurement data
                    valueCell.textContent = measurement.value;
                    readingTypeCell.textContent = measurement.reading_type;
                    createdAtCell.textContent = new Date(measurement.created_at).toLocaleString(); // Formatting the created_at timestamp
                });
            })
            .catch(error => console.error('Error fetching module measurements:', error));
    } else {
        // Clear table if no module is selected
        var tableBody = document.getElementById('measurementTable').getElementsByTagName('tbody')[0];
        tableBody.innerHTML = '';
    }
}

function fetchModuleStatus() {

    fetchModuleMeasurements();
    updateChart();

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

