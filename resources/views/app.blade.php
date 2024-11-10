<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IoT Module Monitoring</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom styles for sidebar layout -->
    <style>
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 18px;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h5 class="text-center">IoT Monitoring</h5>
        <hr>
        <a href="{{ route('dashboard') }}">Dashboard <i class="fa-solid fa-gauge"></i></a>
        <a href="{{ route('modules.index') }}">Modules <i class="fa-solid fa-plus"></i></a>
        <a href="{{ route('module-types.index') }}">Types </a>
        <a href="{{ route('update.status') }}">Generate Readings <i class="fa-solid fa-bolt"></i></a>
        <a href="{{ route('module.status') }}"> Status</a>
      
    </div>

    <div class="content">
    @if(isset($skippedModulesCount) && $skippedModulesCount > 0)
    <div class="alert alert-warning">
        Warning: There are {{ $skippedModulesCount }} modules that failed to report data within the expected time.
        <a href="{{ route('skippedModules.index') }}">View Details</a>
    </div>
@endif
        @yield('content')
    </div>

    <!-- jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
