@extends('layouts.app')

@section('content')
    {{ __('You are redirecting to suppliers...') }}
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var homeUrl = "{{ route('suppliers.index') }}";
            window.location.href = homeUrl;
        });
    </script>
@endpush
