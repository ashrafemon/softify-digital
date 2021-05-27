@extends('layouts.admin')

@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <h4 class="page-title">Create Product</h4>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="productForm" enctype="multipart/form-data">
                        <ul class="nav small flex-column text-danger mb-4" id="validateErrors"></ul>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name"/>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="text" class="form-control" id="price"/>
                        </div>

                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="number" class="form-control" id="stock"/>
                        </div>

                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select id="category_id" class="form-control">
                                <option disabled selected>Select a Category</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="image_1">Image 1</label>
                            <input type="file" class="form-control" id="image_1"/>
                        </div>

                        <div class="form-group">
                            <label for="image_2">Image 2</label>
                            <input type="file" class="form-control" id="image_2"/>
                        </div>

                        <div class="form-group">
                            <label for="image_3">Image 3</label>
                            <input type="file" class="form-control" id="image_3"/>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Add Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-js')
    <script>
        let token = localStorage.getItem('authToken')

        $(document).ready(function () {
            let image_1 = null;
            let image_2 = null;
            let image_3 = null;

            $('#image_1').change(function (e) {
                image_1 = e.target.files[0]
                console.log(image_1)
            })
            $('#image_2').change(function (e) {
                image_2 = e.target.files[0]
            })
            $('#image_3').change(function (e) {
                image_3 = e.target.files[0]
            })

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
                        let categoryField = $('#category_id')
                        res.categories.forEach((item) => {
                            categoryField.append(`
                                <option value="${item.id}">${item.name}</option>
                            `)
                        })
                    }
                },
                error: function (err) {
                    console.log(err)
                }
            })

            $('#productForm').submit(function (e) {
                e.preventDefault()
                let formData = new FormData()
                formData.append('name', $('#name').val())
                formData.append('description', $('#description').val())
                formData.append('stock', $('#stock').val())
                formData.append('price', $('#price').val())
                formData.append('category_id', $('#category_id').val())
                image_1 && formData.append('image_1', image_1)
                image_2 && formData.append('image_2', image_2)
                image_3 && formData.append('image_3', image_3)

                $.ajax({
                    url: '{{url('/api/admin/products')}}',
                    method: 'POST',
                    data: formData,
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('Accept', 'application/json');
                        xhr.setRequestHeader('Authorization', token);
                    },
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        console.log(res)
                        if (res.status === 'validate_error') {
                            generateValidateErrors(res.errors, $('#validateErrors'))
                            setTimeout(() => {
                                clearValidateErrors($('#validateErrors'))
                            }, 4000)
                        } else if (res.status === 'done') {
                            toastr.success(res.message)
                            $('#name').val('')
                            $('#description').val('')
                            $('#stock').val('')
                            $('#price').val('')
                            $('#category_id').val('')
                            $('#image_1').val('')
                            $('#image_2').val('')
                            $('#image_3').val('')
                        }
                    },
                    error: function (err) {
                        console.log(err)
                    }
                })
            })
        })
    </script>
@endpush
