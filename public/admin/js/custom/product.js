$(document).ready(function(){
    allDataProduct()
})

$(document).on('submit', '#insertProductForm', function(e) {
    let inputHidden = $("#test").val()
    let urlRequest;
    if(inputHidden!=null){
        urlRequest = '/api/admin/product/update/'+inputHidden
    }else{
        urlRequest = '/api/admin/product/add'
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
                let imageErr = responseMsg['product_image']
                let nameErr = responseMsg['product_name']
                let descErr = responseMsg['product_desc']
                let categoryErr = responseMsg['category_id']
                let priceErr = responseMsg['product_price']
                if(imageErr != null){
                    validationErrorSwal(imageErr)
                }else if(nameErr != null){
                    validationErrorSwal(nameErr)
                }else if(descErr != null){
                    validationErrorSwal(descErr)
                }else if(categoryErr != null){
                    validationErrorSwal(categoryErr)
                }else if(priceErr != null){
                    validationErrorSwal(priceErr)
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

$(document).on('submit', '#insertImageForm', function(e) {
    let inputHidden = $("#idProduct").val()
    e.preventDefault();
    $.ajax({
        headers: {
            Authorization: `Bearer` + `${localStorage.getItem("jwt_token")}`
        },
        url: '/api/admin/product/add/'+inputHidden,
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
                let imageErr = responseMsg['product_image']
                if(imageErr != null){
                    validationErrorSwal(imageErr)
                } else{
                    serverErrorSwal()
                }
            }else{
                serverErrorSwal()
            }
        }
    });
})

function allDataProduct(){
    $.ajax({
        type: "GET",
        url: "/api/admin/product",
        headers: {
            Authorization: `Bearer` + `${localStorage.getItem("jwt_token")}`
        },
        success: function (result, status, xhr) {
            dataTableProduct(result['data'])
        },
        error: function (xhr, status, error) {
            let responseCode = xhr.status
            if(responseCode == 401){
                window.location.href = "/admin/auth/login"
            }else if(responseCode == 404){
                dataTableProduct([])
            }else{
                alert("Internal server error")
            }
        }
    });
}

function dataTableProduct(productData){
    return $('#tableProduct').dataTable({
        // "processing" : true,
        // "serverSide" : true,
        "bDestroy": true,
        //"responsive": true,
        "data": productData,
        "columns": [
            {
                "data": "product_name"
            },
            {
                "data": function (r){
                    return `Rp. ${rupiahFormatter(r.product_price)}`
                }

            },
            {
                "data": "product_description"
            },
            {
                "data": "category_name"
            },
            {
                "data": null,
                render: function (r){

                    let html = `<div class="d-flex">
                                <a href="#" class="btn btn-success shadow btn-xl sharp mr-1" onclick="detailModal(${r.product_id})"><i class="fa fa-eye"></i></a>
                                <a href="#" onclick="updateProductModal(${r.product_id})" class="btn btn-primary shadow btn-xl sharp mr-1"><i class="fa fa-pencil"></i></a>
                                <a href="#" onclick="insertImageProductModal(${r.product_id})" class="btn btn-info shadow btn-xl sharp mr-1"><i class="fa fa-camera-retro"></i></a>
                                <a href="#" onclick="deleteDataProduct(${r.product_id})" class="btn btn-danger shadow btn-xl sharp"><i class="fa fa-trash"></i></a>
                                </div>`
                    return html
                }
            }

        ]
    });
}

function deleteDataProduct(idDelete){

    Swal.fire({
        title: 'Yakin ingin menghapus produk ?',
        text: "Data yang dihapus tidak dapat dikembalikan",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus Produk'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "DELETE",
                url: "/api/admin/product/delete/"+idDelete,
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
 * Modal Section
 */

function insertImageProductModal(idProduct){
    $('#modalProductImage').modal('show');
    $('#idUpdateImage').append(`<input type="hidden" value="${idProduct}" id="idProduct" name="idProduct">`)
    $("#modalTitle").text("Tambah Gambar Produk");
}

function insertCategoryModal(){
    $.ajax({
        type: "GET",
        url: "/api/admin/category",
        headers: {
            Authorization: `Bearer` + `${localStorage.getItem("jwt_token")}`
        },
        success: function (result, status, xhr) {
            let data = ''
            let categoryOption = (result['data']['data'])
            for(let i in categoryOption){
                let id = categoryOption[i]["category_id"]
                let name = categoryOption[i]["category_name"]
                data+= `<option value="${id}">${name}</option>`
            }
                $("#exampleAppendForm").append(htmlForm(data))
                $('#modalProduct').modal('show');
                $("#modalTitle").text("Tambah Produk");
        },
        error: function (xhr, status, error) {
            let responseCode = xhr.status
            if(responseCode == 401){
                window.location.href = "/admin/auth/login"
            }else if(responseCode == 404){
                serverErrorSwal()
            }else{
                serverErrorSwal()
            }
        }
    });
}

function imageDetailModal(idImage){
    $.ajax({
        type: "GET",
        url: "/api/admin/product/image/"+idImage,
        headers: {
            Authorization: `Bearer` + `${localStorage.getItem("jwt_token")}`
        },
        success: function (result, status, xhr) {
            let imageOption = (result['data'])
            for(let i in imageOption){
                let id = imageOption[i]["index"]
                let image = imageOption[i]["product_image"]
                let status = imageOption[i]["status"]
                $('#modalImageDetail').modal('show');
                $("#listImageProduct").append(htmlImageList(image,status))
            }
        },
        error: function (xhr, status, error) {
            let responseCode = xhr.status
            let responseData = JSON.parse(xhr.responseText)
            if(responseCode == 401){
                window.location.href = "/admin/auth/login"
            }else if(responseCode == 404){
                notFoundSwal(responseData['msg'])
            }else{
                alert("Internal server error")
            }
        }
    });
}

function updateProductModal(idProduct){
    $.ajax({
        type: "GET",
        url: "/api/admin/category",
        headers: {
            Authorization: `Bearer` + `${localStorage.getItem("jwt_token")}`
        },
        success: function (result, status, xhr) {
            let data = ''
            let categoryOption = (result['data']['data'])
            for(let i in categoryOption){
                let id = categoryOption[i]["category_id"]
                let name = categoryOption[i]["category_name"]
                data+= `<option value="${id}">${name}</option>`
            }
            $("#exampleAppendForm").append(htmlForm(data))
            $.ajax({
                type: "GET",
                url: "/api/admin/product/"+idProduct,
                headers: {
                    Authorization: `Bearer` + `${localStorage.getItem("jwt_token")}`
                },
                success: function (result, status, xhr) {
                    $("#modalTitle").text("Update Produk");
                    $("#product_name").val(result['data']['product_name']);
                    $("#product_price").val(result['data']['product_price']);
                    $("#product_description").val(result['data']['product_description']);
                    $("#idUpdate").empty()
                    $("#idUpdate").append(`<input type="hidden" value="${idProduct}" id="test" name="test">`)
                    $('#modalProduct').modal('show');
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

        },
        error: function (xhr, status, error) {
            let responseCode = xhr.status
            if(responseCode == 401){
                window.location.href = "/admin/auth/login"
            }else if(responseCode == 404){
                serverErrorSwal()
            }else{
                serverErrorSwal()
            }
        }
    });

}

function detailModal(idProduct){
    $.ajax({
        type: "GET",
        url: "/api/admin/product/"+idProduct,
        headers: {
            Authorization: `Bearer` + `${localStorage.getItem("jwt_token")}`
        },
        success: function (result, status, xhr) {
            let name = result['data']['product_name']
            let price = result['data']['product_price']
            let description = result['data']['product_description']
            let time = result['data']['last_update']
            let id = result['data']['product_id']
            let image = result['data']['product_image']
            if(image === null){
                image = 'default.png'
            }
            let category = result['data']['category_name']
            $('#modalProductDetail').modal('show');
            $('#detailBodyModal').append(modalDetailBodyHtml(image,name,time,description,category,price,id))
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
    $('#modalProductDetail').modal('hide');
    $('#product_name').val('');
    $('#product_price').val('');
    $('#product_description').val('');
    $('#detailBodyModal').empty();
    $("#exampleAppendForm").empty();
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
 * Html Component
 */

function modalDetailBodyHtml(image,title,time,description,category,price,product_id){
    let html = `<div class="card">
                    <img class="card-img-top img-fluid" src="/assets/images/product/${image}" alt="Card image cap">
                    <div class="card-header">
                        <h5 class="card-title text-wrap
                        ">${title}</h5>
                        <span class="badge badge-pill badge-primary">${category}</span>
                    </div>
                    <div class="card-body">
                    <h5 class="mt-1 font-weight-bold">Rp. ${rupiahFormatter(price)}</h5>
                        <p class="card-text">${description}</p>
                        <p class="card-text text-danger">Terakhir diupdate ${time}</p>
                    </div>

                    <button type="button" onclick="imageDetailModal(${product_id})" class="btn btn-rounded btn-primary mx-auto mb-3"><span class="btn-icon-left text-info"><i class="fa fa-camera-retro color-info"></i></span>Detail Foto</button>

                </div>`
    return html
}

function htmlForm(data){
    let html = `<div class="col-lg-12 mb-2">
                        <div class="form-group">
                            <label class="text-label">Nama Produk</label>
                            <input type="text" id="product_name" name="product_name" class="form-control" placeholder="Masukan nama produk" required>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-2">
                        <div class="form-group">
                            <label class="text-label">Kategori</label>
                            <select class="form-control default-select form-control-lg" id="category_id" name="category_id">
                                ${data}
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-2">
                        <div class="form-group">
                            <label class="text-label">Harga</label>
                            <input type="number" id="product_price" name="product_price" class="form-control" placeholder="Masukan harga produk" required>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-2">
                        <div class="form-group">
                            <label class="text-label">Deskripsi</label>
                            <textarea class="form-control" rows="4" id="product_description" name="product_description"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-3">
                        <div class="form-group">
                            <label class="text-label">Gambar Produk</label>
                            <div class="custom-file">
                                <input type="file" id="product_image" name="product_image" class="custom-file-input">
                                <label class="custom-file-label">Pilih Gambar</label>
                                <label class="small text-danger">*Wajib diisi</label>
                            </div>

                        </div>
                    </div>`
    return html
}

function htmlImageList(image,status){
    let html = `<a href="/assets/images/product/${image}" data-exthumbimage="/assets/images/product/${image}" data-src="/assets/images/product/${image}" class="mb-1 col-lg-4 col-xl-4 col-sm-4 col-6">
                                    <img src="/assets/images/product/${image}" alt="" class="img-fluid mt-2 mb-2">
                                </a>`
    return html
}

/**
 * Support Function
 */

const rupiahFormatter = (number)=>{
    return new Intl.NumberFormat("id-ID", {
        style: "decimal",
        currency: "IDR",
    }).format(number);
}
