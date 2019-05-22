@if (Session::has('success'))
    <script>
        Swal.fire({
            position: 'center',
            type: 'success',
            title: 'Success...',
            text: '{{ Session::get('success') }}',
        });
    </script>
@endif
@if (Session::has('error'))
    <script>
        Swal.fire({
            position: 'center',
            type: 'error',
            title: 'Success...',
            text: '{{Session::get('error')}}',
        });
    </script>
@endif