toastr.options = {"progressBar": true}
function fetchMe(urls) {
    let token = localStorage.getItem('authToken')

    $.ajax({
        url: urls.fetchUrl,
        method: 'GET',
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.setRequestHeader('Authorization', token);
        },
        success: function (res) {
            console.log(res)
            if (res.status === 'done') {
                if (Object.keys(res.user).length && res.user.role === 'user') {
                    window.location.href = urls.homeUrl
                }
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
