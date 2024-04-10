@extends('layouts.layout')

@section('title', 'Maintenance Mode')

@section('content')
    <h1 class="text-center">Wartungsmodus</h1>
    <div class="container">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="maintenanceSwitch" name="maintenanceSwitch" {{$checked ? 'checked': null}}>
            <label class="form-check-label" for="maintenanceSwitch">Wartungsmodus aktivieren</label>
        </div>
    </div>

    <script>
        const maintenanceSwitch = document.getElementById('maintenanceSwitch');
        maintenanceSwitch.addEventListener('change', function() {
            const isActive = this.checked;
            // Send AJAX request to Laravel backend
            fetch('/admin/toggle-maintenance-mode', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Add CSRF token if needed
                },
                body: JSON.stringify({ isActive })
            })
                .then(response => response.json())
                .then(data => {
                   alert(data.message);
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
@endsection





