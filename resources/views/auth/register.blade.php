@extends('layouts.client')

@section('content')
    <div class="wrapper">
        <div class="container my-5">
            <div class="auth">
                <h4 class="authTitle">Registration</h4>

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
                                    {{--                                    <div class="form-group d-flex flex-column align-items-center">--}}
                                    {{--                                        <label for="avatar">Profile Picture</label>--}}
                                    {{--                                        <div class="avatarBox">--}}
                                    {{--                                            <h6 class="avatarBoxText">Upload Image</h6>--}}
                                    {{--                                            <input id="avatar" type="file" class="fileInput"/>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first_name">First Name</label>
                                                <input id="first_name" type="text" class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="last_name">Last Name</label>
                                                <input id="last_name" type="text" class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="user_name">Username</label>
                                                <input id="user_name" type="text" class="form-control"/>
                                            </div>
                                        </div>
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
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="password_confirmation">Confirm Password</label>
                                                <input id="password_confirmation" type="password" class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="phone">Phone</label>
                                                <input id="phone" type="text" class="form-control"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group text-center">
                                        <button class="btn btn-submit">Register</button>
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
                    user_name: $('#user_name').val(),
                    email: $('#email').val(),
                    password: $('#password').val(),
                    password_confirmation: $('#password_confirmation').val(),
                    first_name: $('#first_name').val(),
                    last_name: $('#last_name').val(),
                    phone: $('#phone').val(),
                }

                $.ajax({
                    url: '{{url('/api/auth/register')}}',
                    method: 'POST',
                    data: JSON.stringify(data),
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('Accept', 'application/json');
                        xhr.setRequestHeader('Content-Type', 'application/json');
                    },
                    success: function (res) {
                        console.log(res)
                        if (res.status === 'validate_error') {
                            generateValidateErrors(res.errors, $('#validateErrors'))
                            setTimeout(() => {
                                clearValidateErrors($('#validateErrors'))
                            }, 4000)
                        } else if (res.status === 'done') {
                            toastr.success(res.message)
                            window.location.href = "{{route('login')}}"
                        }
                    }
                })
            })
        })
    </script>
@endpush
