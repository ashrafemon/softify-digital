@extends('layouts.admin')

@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <h4 class="page-title">List Users</h4>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <td>ID</td>
                                <td>Username</td>
                                <td>Email</td>
                                <td>Action</td>
                            </tr>
                            </thead>
                            <tbody id="userTableBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('custom-js')
    <script>
        let token = localStorage.getItem('authToken')

        function deleteUser(id) {
            $.ajax({
                url: '{{url('/api/admin/users')}}/' + id,
                method: 'POST',
                data: {'_method': 'DELETE'},
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Accept', 'application/json');
                    xhr.setRequestHeader('Authorization', token);
                },
                success: function (res) {
                    console.log(res)
                    if (res.status === 'done') {
                        toastr.success(res.message)
                        $(`tr[data-id=${id}]`).remove()
                    }
                },
                error: function (err) {
                    console.log(err)
                }
            })
        }

        $(document).ready(function () {
            $.ajax({
                url: '{{url('/api/admin/users')}}',
                method: 'GET',
                dataType: 'json',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Accept', 'application/json');
                    xhr.setRequestHeader('Authorization', token);
                },
                success: function (res) {
                    console.log(res)
                    if (res.status === 'done') {
                        toastr.success('Users fetch successful')

                        let userTableBody = $('#userTableBody')
                        userTableBody.empty()

                        res.users.length ? res.users.forEach((item, index) => {
                            userTableBody.append(`
                                <tr data-id="${item.id}">
                                    <td>${index + 1}</td>
                                    <td>${item.user_name}</td>
                                    <td>${item.email}</td>
                                    <td>
                                        <button onclick="deleteUser(${item.id})" class="btn btn-warning btn-sm">Delete</button>
                                    </td>
                                </tr>
                            `)
                        }) : userTableBody.append(`
                            <tr>
                                <td colspan="4">No data found...</td>
                            </tr>
                        `)
                    }
                },
                error: function (err) {
                    console.log(err)
                }
            })
        })
    </script>
@endpush
