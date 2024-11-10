@extends('app')

@section('title', 'Generate Status')

@section('content')

<div class="container">

    <!-- Show a success message if the operation is successful -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Show the output from the Artisan command -->
    @if(session('output'))
        <div class="alert alert-info">
            <h5>Response</h5>
            <pre>{{ session('output') }}</pre>
        </div>
    @endif

    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <form action="{{ route('update.module.status') }}" method="POST" id="module-status-form">
        @csrf
        
    </form>

    <button id="simulate-malfunction-btn" type="button" onclick="simulateMalfunction()" class="btn btn-danger">Simulate Malfunction</button>


<div id="malfunction-alert" class="alert alert-danger mt-4" style="display: none;">
    <pre></pre> 
</div>
</div>

@endsection

<script type="text/javascript">

function setupCsrfToken() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
}

function simulateMalfunction() {
    setupCsrfToken(); // Set up the CSRF token

    $.ajax({
        url: '/simulate-malfunction', // Route to simulate malfunction
        type: 'POST', // Use POST method
        success: function(response) {
            // Get the output from the response
            var output = response.message;

            // Insert the output inside the <pre> tag
            $('#malfunction-alert pre').text(output); // Update the alert div with the command output

            // Optionally, show the alert if it's hidden
            $('#malfunction-alert').show();

             
        },
        error: function(xhr, status, error) {
            console.error(error);
            alert("There was an error simulating the malfunction.");
        }
    });
}




    window.onload = function() {
        // Check if the session has the flag 'formSubmitted' by passing the flag to the JavaScript variable
        var formSubmitted = @json(session('formSubmitted', false)); // Pass the session variable as a JavaScript variable

        if (!formSubmitted) {
            // Submit the form automatically when the page loads
            document.getElementById('module-status-form').submit();
        }
    }
</script>
