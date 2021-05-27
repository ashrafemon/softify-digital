@extends('layouts.admin')

@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <h4 class="page-title">List Category</h4>
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
                                <td>Name</td>
                                <td>Slug</td>
                                <td>Action</td>
                            </tr>
                            </thead>
                            <tbody id="categoryTableBody"></tbody>
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

        function deleteCategory(id) {
            $.ajax({
                url: '{{url('/api/admin/categories')}}/' + id,
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

        {{--function editCategory(id) {--}}
        {{--    let url = '{{ route("admin.categories.edit", ":id") }}'--}}
        {{--    url = url.replace(':id', id);--}}
        {{--    window.location.href = url--}}
        {{--}--}}

        $(document).ready(function () {
            $.ajax({
                url: '{{url('/api/admin/categories')}}',
                method: 'GET',
                dataType: 'json',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Accept', 'application/json');
                    xhr.setRequestHeader('Authorization', token);
                },
                success: function (res) {
                    console.log(res)
                    if (res.status === 'done') {
                        toastr.success('Category fetch successful')

                        let categoryTableBody = $('#categoryTableBody')
                        categoryTableBody.empty()

                        res.categories.length ? res.categories.forEach((item, index) => {
                            categoryTableBody.append(`
                                <tr data-id="${item.id}">
                                    <td>${index + 1}</td>
                                    <td>${item.name}</td>
                                    <td>${item.slug}</td>
                                    <td>
                                        <button onclick="deleteCategory(${item.id})" class="btn btn-warning btn-sm">Delete</button>
                                    </td>
                                </tr>
                            `)
                        }) : categoryTableBody.append(`
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
