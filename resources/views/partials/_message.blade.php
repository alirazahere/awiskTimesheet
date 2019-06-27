@if (Session::has('success'))
    <script>
        Swal.fire({
            position: 'center',
            type: 'success',
            title: 'Success...',
            html: '{{ Session::get('success') }}',
        });
    </script>
@endif
@if (Session::has('error'))
    <script>
        Swal.fire({
            position: 'center',
            type: 'error',
            title: 'Error...',
            html: '{{Session::get('error')}}',
        });
    </script>
@endif