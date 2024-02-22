
    @extends('layouts.app')

    @section('content')
        @include('returns.show')
    @stop
    @push('js')
        <script>
            window.print();
        </script>
    @endpush
