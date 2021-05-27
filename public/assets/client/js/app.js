$(document).ready(function () {
    toastr.options = {"progressBar": true}

    $('#homeSlider').owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        nav: false,
        dots: false,
    })
})

function setCarousel (){
    $('.productsCarousel').owlCarousel({
        // loop: true,
        autoplay: true,
        nav: false,
        dots: false,
        margin: 10,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 4
            }
        }
    })
}
