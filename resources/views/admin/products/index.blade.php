@extends('layouts.admin')

@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <h4 class="page-title">List Products</h4>
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
                                <td>Category</td>
                                <td>Price</td>
                                <td>Stock</td>
                                <td>Action</td>
                            </tr>
                            </thead>
                            <tbody id="productTableBody"></tbody>
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

        function deleteProduct(id) {
            $.ajax({
                url: '{{url('/api/admin/products')}}/' + id,
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

        {{--function editProduct(id) {--}}
        {{--    let url = '{{ route("admin.products.edit", ":id") }}'--}}
        {{--    url = url.replace(':id', id);--}}
        {{--    window.location.href = url--}}
        {{--}--}}

        $(document).ready(function () {
            $.ajax({
                url: '{{url('/api/admin/products')}}',
                method: 'GET',
                dataType: 'json',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Accept', 'application/json');
                    xhr.setRequestHeader('Authorization', token);
                },
                success: function (res) {
                    console.log(res)
                    if (res.status === 'done') {
                        toastr.success('Products fetch successful')

                        let productTableBody = $('#productTableBody')
                        productTableBody.empty()

                        res.products.length ? res.products.forEach((item, index) => {
                            productTableBody.append(`
                                <tr data-id="${item.id}">
                                    <td>${index + 1}</td>
                                    <td>${item.name}</td>
                                    <td>${item.slug}</td>
                                    <td>${item.category.name}</td>
                                    <td>${item.price}</td>
                                    <td>${item.stock}</td>
                                    <td>
                                        <button onclick="deleteProduct(${item.id})" class="btn btn-warning btn-sm">Delete</button>
                                    </td>
                                </tr>
                            `)
                        }) : productTableBody.append(`
                            <tr>
                                <td colspan="7">No data found...</td>
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
