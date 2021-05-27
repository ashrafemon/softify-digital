@extends('layouts.admin')

@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>
        </div>

        <div class="container-fluid">

        </div>
    </div>
@endsection

@push('custom-js')
    <script>
        {{--let urls = {--}}
        {{--    fetchUrl: '{{url('/api/profile')}}',--}}
        {{--    homeUrl: '{{route('home')}}',--}}
        {{--    dashboardUrl: '{{route('admin.dashboard.index')}}',--}}
        {{--}--}}
        {{--fetchMe(urls)--}}
    </script>
@endpush
