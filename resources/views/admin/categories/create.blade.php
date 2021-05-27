@extends('layouts.admin')

@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <h4 class="page-title">Create Category</h4>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="categoryForm">
                        <ul class="nav small flex-column text-danger mb-4" id="validateErrors"></ul>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name"/>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Add Category</button>
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
            let nameField = $('#name')
            let nameValue = nameField.val()

            nameField.change(function () {
                nameValue = $(this).val()
            })

            $('#categoryForm').submit(function (e) {
                e.preventDefault()
                let data = {name: nameValue}
                $.ajax({
                    url: '{{url('/api/admin/categories')}}',
                    method: 'POST',
                    data: JSON.stringify(data),
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('Accept', 'application/json');
                        xhr.setRequestHeader('Content-Type', 'application/json');
                        xhr.setRequestHeader('Authorization', token);
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
                            nameValue = ''
                            nameField.val('')
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
