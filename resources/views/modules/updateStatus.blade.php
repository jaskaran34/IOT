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

    <form action="{{ route('update.module.status') }}" method="POST" id="module-status-form">
        @csrf
        <button type="submit" class="btn btn-primary" id="submit-button" >Update Status</button>
    </form>
    
</div>

@endsection

<script type="text/javascript">
    window.onload = function() {
        // Check if the session has the flag 'formSubmitted' by passing the flag to the JavaScript variable
        var formSubmitted = @json(session('formSubmitted', false)); // Pass the session variable as a JavaScript variable

        if (!formSubmitted) {
            // Submit the form automatically when the page loads
            document.getElementById('module-status-form').submit();
        }
    }
</script>
