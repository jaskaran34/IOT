@extends('app')

@section('title', 'Dashboard')

@section('content')
<div class="container">

<div class="row">
        <div class="col-md-4">
            <div class="card" onclick="openDynamicModal('Total Modules', '{{route('modules.all','0') }}' )"
             style="cursor: pointer;">
                <div class="card-header">Total Modules</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalModules }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
        <div class="card" onclick="openDynamicModal('Active Modules', '{{route('modules.all','1') }}' )"
        style="cursor: pointer;">
                <div class="card-header">Active Modules</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $activeModules }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
        <div class="card" onclick="openDynamicModal('Inactive Modules', '{{route('modules.all','2') }}' )"
        style="cursor: pointer;">
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
                <td><button type="button" onclick="popup('{{ $module['name'] }}','{{ $module['id'] }}',
                '{{ $module['measurement_type_name'] }}',
                '{{ $module['status'] }}',
                '{{ $module['measurements_count'] }}',
                '{{ $module['last_measurement_value'] }}',
                '{{ Carbon\Carbon::parse($module['last_measurement_timestamp'])->diffForHumans() }}',
                '{{ Carbon\Carbon::parse($module['created_at'])->diffForHumans()}}',
                '{{ $module['status'] == 'active' ? Carbon\Carbon::parse($module['updated_at'])->diffForHumans() : '' }}',
                
                )" class="btn btn-link">Details</button></td>
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

<!-- Reusable Modal -->
<div class="modal fade" id="dynamicModal" tabindex="-1" aria-labelledby="dynamicModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dynamicModalLabel">Modal Title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="dynamicModalBody">
                <!-- Content will be populated dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>

    function popup(name,moduleId,type,status,measurements_count,last_measurement_value,last_measurement_timestamp,created_at,updated_at){
        document.getElementById('dynamicModalLabel').textContent = name + ' Module';

        const modalBody = document.getElementById('dynamicModalBody');
        modalBody.innerHTML = '<p>Loading...</p>';

        let html1 = ` <table class="table table-bordered"> <tbody> <tr> <th>Name</th> <td>${name}</td> </tr> <tr> <th>Module ID</th> <td>${moduleId}</td> </tr> <tr> <th>Type</th> <td>${type}</td> </tr> <tr> <th>Status</th> <td>${status}</td> </tr> <tr> <th>Measurements Count</th> <td>${measurements_count}</td> </tr> <tr> <th>Last Measurement Value</th> <td>${last_measurement_value}</td> </tr> <tr> <th>Last Measurement Timestamp</th> <td>${last_measurement_timestamp}</td> </tr> <tr> <th>Created At</th> <td>${created_at}</td> </tr> <tr> <th>Updated At</th> <td>${updated_at}</td> </tr> </tbody> </table>`;
        let html2=`<h4>Status Monitorings (Latest 10)</h4>
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
        </table>`;
        modalBody.innerHTML = html1+html2;


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


        
        var dynamicModal = new bootstrap.Modal(document.getElementById('dynamicModal'));
        dynamicModal.show();

    }
    function openDynamicModal(title, url) {
        // Set the modal title
        document.getElementById('dynamicModalLabel').textContent = title;

        // Show a loading message initially
        const modalBody = document.getElementById('dynamicModalBody');
        modalBody.innerHTML = '<p>Loading...</p>';

        // Fetch data from the server
        fetch(url)
            .then(response => response.json())
            .then(data => {
                // Generate HTML table for the module data
                let html = `
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>S.no</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Last Updated</th>
                            </tr>
                        </thead>
                        <tbody>`;

                // Populate rows with module data
                let ct=1;
                data.forEach(module => {
                    html += `
                        <tr>
                           <td>${ct}</td>
                            <td>${module.id}</td>
                            <td>${module.name}</td>
                            <td>${module.status}</td>
                            <td>${module.created_at ?? 'N/A'}</td>
                            <td>${module.updated_at ?? 'N/A'}</td>
                        </tr>`;
                        ct++;
                });

                html += '</tbody></table>';

                // Update modal body content with the table
                modalBody.innerHTML = html;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                modalBody.innerHTML = '<p>Failed to load data.</p>';
            });

        // Show the modal
        var dynamicModal = new bootstrap.Modal(document.getElementById('dynamicModal'));
        dynamicModal.show();
    }
</script>




@endsection
