$(document).ready(function(){
    allUser()
})

/**
 * Start Main Function
 */

function allUser(){
    $.ajax({
        type: "GET",
        url: "/api/admin/user",
        headers: {
            Authorization: `Bearer` + `${localStorage.getItem("jwt_token")}`
        },
        success: function (result, status, xhr) {
            dataTableUser(result['data'])
        },
        error: function (xhr, status, error) {
            let responseCode = xhr.status
            if(responseCode == 401){
                window.location.href = "/admin/auth/login"
            }else if(responseCode == 404){
                dataTableUser([])
            }else{
                alert("Internal server error")
            }
        }
    });
}

function dataTableUser(userData){
    return $('#tableUser').dataTable({
        // "processing" : true,
        // "serverSide" : true,
        "bDestroy": true,
        //"responsive": true,
        "data": userData,
        "columns": [
            {
                "data": "name"
            },
            {
                "data": "username"
            },
            {
                "data": "email"
            },
            {
                "data": null,
                render: function (r){

                    let html = `<div class="d-flex">
                                <a href="#" class="btn btn-success shadow btn-xl sharp mr-1" onclick="detailModal(${r.id})"><i class="fa fa-eye"></i></a>
                                <a href="#" onclick="deleteDataUser(${r.id})" class="btn btn-danger shadow btn-xl sharp"><i class="fa fa-trash"></i></a>
                                </div>`
                    return html
                }
            }

        ]
    });
}

$(document).on('submit', '#insertModalForm', function(e) {
    e.preventDefault();
    $.ajax({
        headers: {
            Authorization: `Bearer` + `${localStorage.getItem("jwt_token")}`
        },
        url: '/api/admin/user/add',
        type: 'post',
        data: new FormData(this),
        dataType: "json",
        enctype: 'multipart/form-data',
        contentType: false,
        cache: false,
        processData: false,
        success: function (result, status, xhr) {
            let msg = result['msg']
            successSwal(msg)
        },
        error: function (xhr, status, error) {
            let responseCode = xhr.status
            if(responseCode === 401){
                window.location.href = "/admin/auth/login"
            }else if(responseCode === 400){
                let responseData = JSON.parse(xhr.responseText)
                let responseMsg = JSON.parse(responseData['msg'])
                let imageErr = responseMsg['image']
                let nameErr = responseMsg['name']
                let usernameErr = responseMsg['username']
                let emailErr = responseMsg['email']
                let passwordErr = responseMsg['password']
                if(imageErr != null){
                    validationErrorSwal(imageErr)
                }else if(nameErr != null){
                    validationErrorSwal(nameErr)
                }else if(usernameErr != null){
                    validationErrorSwal(usernameErr)
                }else if(emailErr != null){
                    validationErrorSwal(emailErr)
                }else if(passwordErr != null){
                    validationErrorSwal(passwordErr)
                }
                else{
                    serverErrorSwal()
                }
            }else{
                serverErrorSwal()
            }
        }
    });
})

/**
 * Modal
 * @param idProduct
 */

function insertUserModal(){
    $('#modalUser').modal('show');
    $("#modalTitle").text("Tambah Pengguna");
}

function detailModal(idProduct){
    $.ajax({
        type: "GET",
        url: "/api/admin/user/"+idProduct,
        headers: {
            Authorization: `Bearer` + `${localStorage.getItem("jwt_token")}`
        },
        success: function (result, status, xhr) {
            let name = result['data']['name']
            let email = result['data']['email']
            let username = result['data']['username']
            let image = result['data']['image']
            let level = titleCase(result['data']['level'])
            if(image === null){
                image = 'admin.png'
            }
            let category = result['data']['category_name']
            $('#modalUserDetail').modal('show');
            $('#detailBodyModal').append(modalDetailBodyHtml(image,name,username,email,level))
        },
        error: function (xhr, status, error) {
            let responseCode = xhr.status
            if(responseCode === 401){
                window.location.href = "/admin/auth/login"
            }else if(responseCode === 404){
                let errMsg = JSON.parse(xhr.responseText)
                notFoundSwal(errMsg['msg'])
            }else{
                serverErrorSwal()
            }
        }
    });
}

function closeModal(){
    $('#modalUserDetail').modal('hide');
    $("#name").val('');
    $("#username").val('');
    $("#email").val('');
    $("#password").val('');
    $("#modalTitle").text("");
    $('#detailBodyModal').empty();
}

function deleteDataUser(idDelete){

    Swal.fire({
        title: 'Yakin ingin menghapus pengguna ?',
        text: "Data yang dihapus tidak dapat dikembalikan",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus Pengguna'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "DELETE",
                url: "/api/admin/user/delete/"+idDelete,
                headers: {
                    Authorization: `Bearer` + `${localStorage.getItem("jwt_token")}`
                },
                success: function (result, status, xhr) {
                    let msg = result['msg']
                    successSwal(msg)
                },
                error: function (xhr, status, error) {
                    let responseCode = xhr.status
                    let responseData = JSON.parse(xhr.responseText)
                    if(responseCode === 401){
                        window.location.href = "/admin/auth/login"
                    }else if(responseCode === 404){
                        notFoundSwal(responseData['msg'])
                        window.location.reload()
                    }else{
                        serverErrorSwal()
                    }
                }
            });
        }
    })
}

/**
 * Html Function
 */

function modalDetailBodyHtml(image,name,username,email,level){
    let html = `<div class="card">
                    <img class="card-img-top img-fluid" src="/admin/images/avatar/${image}" alt="Card image cap">
                    <div class="card-header">
                        <h5 class="card-title text-wrap
                        ">${name}</h5>
                        <span class="badge badge-pill badge-primary">${level}</span>
                    </div>
                    <div class="card-body">
                    <div class="profile-personal-info">
                                                    <h4 class="text-primary mb-4">Personal Information</h4>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-3 col-5">
                                                            <h5 class="f-w-500">Nama <span class="pull-right">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-sm-9 col-7"><span>${name}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-3 col-5">
                                                            <h5 class="f-w-500">Email <span class="pull-right">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-sm-9 col-7"><span>${email}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-3 col-5">
                                                            <h5 class="f-w-500">User<span class="pull-right">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-sm-9 col-7"><span>${username}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-3 col-5">
                                                            <h5 class="f-w-500">Level <span class="pull-right">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-sm-9 col-7"><span>${level}</span>
                                                        </div>
                                                    </div>
                                                </div>
                    </div>
                </div>`
    return html
}

/**
 * Sweet Alert Section
 * @param msg
 */

function successSwal(msg){
    Swal.fire({
        position: 'mid-end',
        icon: 'success',
        title: 'Berhasil !',
        text: msg,
        showConfirmButton: false,
        timer: 1500
    }).then(function(){
        window.location.reload()
    })
}

function notFoundSwal(msg){
    Swal.fire({
        icon: 'error',
        title: 'Content Not Found',
        text: msg,
    })
}

function serverErrorSwal(){
    Swal.fire({
        icon: 'error',
        title: 'Internal Server Error',
        text: 'Terjadi kesalahan pada server. Silahkan coba lagi',
    })
}

function validationErrorSwal(data) {
    const addOption = (arr) => {
        let optionItems = "";
        arr.forEach((item,index) =>{
            optionItems += `<li>${index +1}. ${item}</li>`
        })
        return optionItems
    }

    Swal.fire({
        icon: 'error',
        title: 'Terjadi kesalahan !',
        html: `<h4>Pesan Kesalahan :</h4><br>` + addOption(data) + `<br>Perhatikan pesan kesalahan dan silahkan coba lagi`
    })
}

/**
 * Helper Function
 */

function titleCase(st) {
    return st.split(" ").reduce( (s, c) =>
        s +""+(c.charAt(0).toUpperCase() + c.slice(1) +" "), '');
}
