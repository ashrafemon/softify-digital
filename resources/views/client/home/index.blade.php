@extends('layouts.client')

@section('content')
    <div class="wrapper">
        <div id="homeSlider" class="owl-carousel owl-theme">
            <div class="item">
                <img src="{{asset('assets/client/images/slider/Slider.png')}}" alt="Slider 1"/>
            </div>
            <div class="item">
                <img src="{{asset('assets/client/images/slider/Slider.png')}}" alt="Slider 2"/>
            </div>
        </div>

        <div class="container my-5">
            <div class="products">
                <div class="portion mb-5">
                    <h5 class="portionTitle">New Arrivals <a href="" class="seeAllBtn">See all</a></h5>

                    <div id="newArrivalProducts" class="productsCarousel owl-carousel owl-theme"></div>
                </div>
            </div>

            <div class="adsContainer">
                <img src="{{asset('assets/client/images/new-banner.png')}}" alt="Ads">
                <div class="adsContent">
                    <h4 class="offPercentage">50% Off</h4>
                    <h6 class="addContentText">On all Items</h6>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('custom-js')
    <script>
        $(document).ready(function () {
            $.ajax({
                url: '{{url('api/products/items/new_arrivals')}}',
                method: 'GET',
                dataType: 'json',
                success: function (res) {
                    console.log(res)

                    let newArrivalProducts = $('#newArrivalProducts')
                    newArrivalProducts.empty()

                    if (res.status === 'done') {
                        res.products.length ? res.products.forEach((item) => {
                            newArrivalProducts.append(`
                                <div class="item py-2" data-id="${item.id}">
                                    <div class="card productCardItem">
                                        <div class="card-img-top">
                                            <img src="${item.images.length ? item.images[0] : 'assets/client/images/default.png'}"
                                                 alt="Product Image">
                                            <span class="categoryName">${item.category.name}</span>
                                        </div>
                                        <div class="card-body productCardBody">
                                            <h6 class="productName">${item.name}</h6>
                                            <h6 class="productPrice">${item.price}</h6>
                                            <button onclick="addToCart(${item.id}, 1, ${item.price}, '{{url('/api/carts')}}')" class="btn btn-view-product btn-block btn-sm">Add to Cart</button>
                                            <button class="btn btn-view-product btn-block btn-sm">View Product</button>
                                        </div>
                                    </div>
                                </div>
                            `)
                        }) : newArrivalProducts.append(`
                            <h3>No Products Available...</h3>
                        `)

                        setCarousel()
                    }
                },
                error: function (err) {
                    console.log(err)
                }
            })
        })
    </script>
@endpush
