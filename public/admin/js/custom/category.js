$(document).ready(function(){
    allDataCatergory()
})

$(document).on('submit', '#insertCategoryForm', function(e) {
    let inputHidden = $("#test").val()
    let urlRequest;
    if(inputHidden!=null){
        urlRequest = '/api/admin/category/update/'+inputHidden
    }else{
        urlRequest = '/api/admin/category/add'
    }

    e.preventDefault();
    $.ajax({
        headers: {
            Authorization: `Bearer` + `${localStorage.getItem("jwt_token")}`
        },
        url: urlRequest,
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
            console.log(inputHidden)
        },
        error: function (xhr, status, error) {
            let responseCode = xhr.status
            if(responseCode === 401){
                window.location.href = "/admin/auth/login"
            }else if(responseCode === 400){
                let responseData = JSON.parse(xhr.responseText)
                let responseMsg = JSON.parse(responseData['msg'])
                let imageErr = responseMsg['category_image']
                let categoryNameErr = responseMsg['category_name']
                if(imageErr != null){
                    validationErrorSwal(imageErr)
                }else if(categoryNameErr != null){
                    validationErrorSwal(categoryNameErr)
                }else{
                    serverErrorSwal()
                }
            }else{
                serverErrorSwal()
            }
        }
    });
})

function allDataCatergory(){
    $.ajax({
        type: "GET",
        url: "/api/admin/category",
        headers: {
            Authorization: `Bearer` + `${localStorage.getItem("jwt_token")}`
        },
        success: function (result, status, xhr) {
            dataTableCategory(result['data']['data'])
        },
        error: function (xhr, status, error) {
            let responseCode = xhr.status
            if(responseCode == 401){
                window.location.href = "/admin/auth/login"
            }else if(responseCode == 404){
                dataTableCategory([])
            }else{
                alert("Internal server error")
            }
        }
    });
}

function deleteDataCategory(idDelete){

    Swal.fire({
        title: 'Yakin ingin menghapus kategori ?',
        text: "Data yang dihapus tidak dapat dikembalikan",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus Kategori'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "DELETE",
                url: "/api/admin/category/delete/"+idDelete,
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

function dataTableCategory(categoryData){
    return $('#tableCategory').dataTable({
        // "processing" : true,
        // "serverSide" : true,
        "bDestroy": true,
        //"responsive": true,
        "data": categoryData,
        "columns": [
            {
                "data": "category_name"
            },
            {
                "data": "category_id"
            },
            {
                "data": null,
                render: function (r){
                    let imageUrl = ""
                    if(r.category_image === null){
                        imageUrl = 'default.png'
                    }else {
                        imageUrl = r.category_image
                    }
                    let html = `<img class="rounded-circle" width="50" src="/assets/images/categories/${imageUrl}" alt="">`
                    return html
                }
            },
            {
                "data": null,
                render: function (r){

                    let html = `<div class="d-flex">
                                <a href="#" class="btn btn-success shadow btn-xl sharp mr-1" onclick="detailModal(${r.category_id})"><i class="fa fa-eye"></i></a>
                                <a href="#" onclick="updateCategoryModal(${r.category_id})" class="btn btn-primary shadow btn-xl sharp mr-1"><i class="fa fa-pencil"></i></a>
                                <a href="#" onclick="deleteDataCategory(${r.category_id})" class="btn btn-danger shadow btn-xl sharp"><i class="fa fa-trash"></i></a>
                                </div>`
                    return html
                }
            }

        ]
    });
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
 * Modal Section
 */

function insertCategoryModal(){
    $('#modalCategory').modal('show');
    $("#modalTitle").text("Tambah Kategori");
}

function updateCategoryModal(idCategory){
    $.ajax({
        type: "GET",
        url: "/api/admin/category/"+idCategory,
        headers: {
            Authorization: `Bearer` + `${localStorage.getItem("jwt_token")}`
        },
        success: function (result, status, xhr) {
            $('#modalCategory').modal('show');
            $("#modalTitle").text("Update Kategori");
            $("#category_name").val(result['data']['category_name']);
            $("#idUpdate").empty()
            $("#idUpdate").append(`<input type="hidden" value="${idCategory}" id="test" name="test">`)
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

function detailModal(idCategory){
    $.ajax({
        type: "GET",
        url: "/api/admin/category/"+idCategory,
        headers: {
            Authorization: `Bearer` + `${localStorage.getItem("jwt_token")}`
        },
        success: function (result, status, xhr) {
            let name = result['data']['category_name']
            let image = result['data']['category_image']
            if(image === null){
                image = 'default.png'
            }
            let time = result['data']['updated_at']
            $('#modalCategoryDetail').modal('show');
            $('#detailBodyModal').append(modalDetailBodyHtml(image,name,time))
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
    $('#modalCategory').modal('hide');
    $("#category_name").val('');
    //$("#category_image").val('');
    $("#modalTitle").text("");
}

/**
 * Html Component
 */

function modalDetailBodyHtml(image,title,time){
    let html = `<div class="card">
                    <img class="card-img-top img-fluid" src="/assets/images/categories/${image}" alt="Card image cap">
                    <div class="card-header">
                        <h5 class="card-title">${title}</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Kategori tidak memiliki deskripsi</p>
                        <p class="card-text text-danger">Terakhir diupdate ${time}</p>
                    </div>
                </div>`
    return html
}
