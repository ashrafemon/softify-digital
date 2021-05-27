@extends('layouts.client')

@section('content')
    <div class="wrapper">
        <div class="container my-5">
            <div class="auth">
                <h4 class="authTitle">Login</h4>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-8 col-12">
                                <div class="row justify-content-center mb-1">
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <button class="btn btn-social-login btn-block">Register with Google
                                            </button>
                                        </div>

                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <button class="btn btn-social-login btn-block">Register with Facebook
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <button class="btn btn-social-login btn-block">Register with Github
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <hr/>

                                <form class="authForm">
                                    <ul class="nav small flex-column text-danger mb-4" id="validateErrors"></ul>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input id="email" type="email" class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input id="password" type="password" class="form-control"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn-submit">Login</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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

        $(document).ready(function () {
            $('.authForm').submit(function (e) {
                e.preventDefault()

                let data = {
                    email: $('#email').val(),
                    password: $('#password').val(),
                }

                $.ajax({
                    url: '{{url('/api/auth/login')}}',
                    method: 'POST',
                    data: JSON.stringify(data),
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('Accept', 'application/json');
                        xhr.setRequestHeader('Content-Type', 'application/json');
                    },
                    success: function (res) {
                        console.log(res)
                        if (res.status === 'error') {
                            toastr.error(res.message)
                        } else if (res.status === 'validate_error') {
                            generateValidateErrors(res.errors, $('#validateErrors'))
                            setTimeout(() => {
                                clearValidateErrors($('#validateErrors'))
                            }, 4000)
                        } else if (res.status === 'done') {
                            toastr.success(res.message)
                            localStorage.setItem('authToken', res.token)
                            if (res.user.role === 'admin') {
                                window.location.href = "{{route('admin.dashboard.index')}}"
                            } else if (res.user.role === 'user') {
                                window.location.href = "{{route('home')}}"
                            }
                        }
                    }
                })
            })
        })
    </script>
@endpush

