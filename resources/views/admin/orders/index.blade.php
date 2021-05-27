@extends('layouts.admin')

@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <h4 class="page-title">List Orders</h4>
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
                                <td>Invoice ID</td>
                                <td>Products</td>
                                <td>Total Price</td>
                                <td>Status</td>
                                <td>Action</td>
                            </tr>
                            </thead>
                            <tbody id="orderTableBody">
                            <tr>
                                <td>01</td>
                                <td>Mens</td>
                                <td>
                                    <button class="btn btn-warning btn-sm">Edit</button>
                                    <button class="btn btn-warning btn-sm">Delete</button>
                                </td>
                            </tr>
                            </tbody>
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
                url: '{{url('/api/admin/orders')}}',
                method: 'GET',
                dataType: 'json',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Accept', 'application/json');
                    xhr.setRequestHeader('Authorization', token);
                },
                success: function (res) {
                    console.log(res)
                    if (res.status === 'done') {
                        toastr.success('Orders fetch successful')

                        let orderTableBody = $('#orderTableBody')
                        orderTableBody.empty()

                        res.orders.length ? res.orders.forEach((item, index) => {
                            let products = [];
                            item.carts.forEach((cart) => products.push({
                                name: cart.product.name,
                                quantity: cart.quantity,
                                unit_price: cart.unit_price
                            }))
                            console.log(products)

                            orderTableBody.append(`
                                <tr data-id="${item.id}">
                                    <td>${index + 1}</td>
                                    <td>${item.invoice_id}</td>
                                    <td>${JSON.stringify(products)}</td>
                                    <td>${item.total_price}</td>
                                    <td>${item.status}</td>
                                    <td>
                                        <button onclick="deleteCategory(${item.id})" class="btn btn-warning btn-sm">Delete</button>
                                    </td>
                                </tr>
                            `)
                        }) : orderTableBody.append(`
                            <tr>
                                <td colspan="5">No data found...</td>
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
