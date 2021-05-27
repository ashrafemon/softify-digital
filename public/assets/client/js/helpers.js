// Fetch Login User
function fetchMe() {
    let token = localStorage.getItem('authToken')

    let guestLinks = $('.guestLinks')
    if (!guestLinks.length) {
        $('#mainMenu').append(`
            <li class="nav-item guestLinks">
                <a href="{{route('login')}}" class="nav-link">Login</a>
            </li>
            <li class="nav-item guestLinks">
                <a href="{{route('register')}}" class="nav-link">Register</a>
            </li>
        `)
    }

    if (token) {
        $.ajax({
            url: window.origin + '/api/profile',
            method: 'GET',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.setRequestHeader('Authorization', token);
            },
            success: function (res) {
                console.log(res)
                if (res.status === 'done') {
                    Object.keys(res.user).length && $('#mainMenu').append(`
                        <li class="nav-item">
                            <a href="${window.origin + '/carts'}" class="nav-link">
                                <i class="fas fa-shopping-cart"></i> <span id="cartLink" class="badge badge-secondary">0</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a onclick="logout()" href="javascript:void(0)" class="nav-link">Logout</a>
                        </li>
                    `)

                    if (guestLinks.length) {
                        guestLinks.remove()
                    }
                }
            },
            error: function (err) {
                console.log(err)
            }
        })
    }
}

function logout() {
    $.ajax({
        url: window.origin + '/api/auth/logout',
        method: 'POST',
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.setRequestHeader('Authorization', localStorage.getItem('authToken'));
        },
        success: function (res) {
            console.log(res)
            if (res.status === 'done') {
                localStorage.removeItem('authToken')
                window.location.href = window.origin
            }
        },
        error: function (err) {
            console.log(err)
        }
    })
}

// Validation Errors
function generateValidateErrors(errors, selector) {
    toastr.error('Validation Error')
    Object.keys(errors).forEach((key) => {
        selector.append(`
            <li class="nav-item">${errors[key][0]}</li>
        `)
    })
}

function clearValidateErrors(selector) {
    selector.empty()
}

// Cart
function addToCart(id, quantity, price, url) {
    let token = localStorage.getItem('authToken')

    if (!token) {
        toastr.error('Please login in first')
    } else {
        let data = {
            product_id: id,
            quantity: quantity,
            unit_price: price
        }
        $.ajax({
            url: url,
            method: "POST",
            data: data,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Accept', 'application/json')
                xhr.setRequestHeader('Authorization', token)
            },
            success: function (res) {
                console.log(res)
                if (res.status === 'done') {
                    toastr.success(res.message)
                    fetchCarts()
                }
            },
            error: function (err) {
                console.log(err)
            }
        })
    }
}

function fetchCarts() {
    let token = localStorage.getItem('authToken')

    if (!token) {
        toastr.error('Please login in first')
    } else {
        $.ajax({
            url: window.origin + '/api/carts',
            method: "GET",
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Accept', 'application/json')
                xhr.setRequestHeader('Authorization', token)
            },
            success: function (res) {
                console.log(res)
                if (res.status === 'done') {
                    let cartLink = $('#cartLink')
                    res.carts.length > 0 ?
                        cartLink.text(res.carts.length).addClass('bg-danger').removeClass('bg-secondary') :
                        cartLink.text(0)

                    let cartTableBody = $('#cartTableBody')

                    if (cartTableBody) {
                        res.carts.length ? res.carts.forEach((item, index) => {
                            cartTableBody.append(`
                                <tr data-id="${item.id}">
                                    <td>${index + 1}</td>
                                    <td>${item.product.name}</td>
                                    <td>${item.quantity}</td>
                                    <td>${item.unit_price}</td>
                                    <td>${item.total_price}</td>
                                    <td>
                                        <button onclick="deleteCart(${item.id})" class="btn btn-danger btn-sm">X</button>
                                    </td>
                                </tr>
                            `)
                        }) : cartTableBody.append(`
                            <tr>
                                <td colspan="6">no carts found</td>
                            </tr>
                        `)

                        res.carts.length && $('#checkOutBtnBox').append(`
                            <button onclick="checkout()" class="btn btn-primary">Checkout</button>
                        `)

                    }
                }
            },
            error: function (err) {
                console.log(err)
            }
        })
    }
}

function deleteCart(id) {
    let token = localStorage.getItem('authToken')

    if (!token) {
        toastr.error('Please login in first')
    } else {
        $.ajax({
            url: window.origin + '/api/carts/' + id,
            method: "POST",
            data: {
                '_method': 'DELETE'
            },
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Accept', 'application/json')
                xhr.setRequestHeader('Authorization', token)
            },
            success: function (res) {
                console.log(res)
                if (res.status === 'done') {
                    toastr.success(res.message)
                    $(`tr[data-id=${id}]`).remove()
                    let cartLink = $('#cartLink')
                    let cartLinkValue = parseInt(cartLink.text()) - 1
                    cartLink.text(cartLinkValue)
                }
            },
            error: function (err) {
                console.log(err)
            }
        })
    }
}

function checkout() {
    let token = localStorage.getItem('authToken')
    // let carts = $('#cartTableBody tr[data-id]')
    let carts = document.querySelectorAll('#cartTableBody tr[data-id]')
    console.log(carts)

    if (!token) {
        toastr.error('Please login to continue')
    } else {
        if (carts.length) {
            let carts_id = []
            carts.forEach((item) => {
                carts_id.push(parseInt(item.getAttribute('data-id')))
            })

            $.ajax({
                url: window.origin + '/api/orders',
                method: 'POST',
                data: {carts_id: carts_id},
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Accept', 'application/json')
                    xhr.setRequestHeader('Authorization', token)
                },
                success: function (res) {
                    console.log(res)
                    if (res.status === 'done') {
                        toastr.success(res.message)
                        window.location.href = window.origin
                    }
                },
                error: function (err) {
                    console.log(err)
                }
            })

        }
    }

}
