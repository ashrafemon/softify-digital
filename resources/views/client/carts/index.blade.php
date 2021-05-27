@extends('layouts.client')

@section('content')
    <div class="wrapper">
        <div class="container my-5">
            <h2>Carts</h2>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="table-responsive mb-5">
                        <table class="table">
                            <thead>
                            <tr>
                                <td>No.</td>
                                <td>Product</td>
                                <td>Quantity</td>
                                <td>Unit Price</td>
                                <td>Total Price</td>
                                <td>Action</td>
                            </tr>
                            </thead>
                            <tbody id="cartTableBody">
                            </tbody>
                        </table>
                    </div>

                    <div id="checkOutBtnBox" class="text-right">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-js')
    <script>

    </script>
@endpush

