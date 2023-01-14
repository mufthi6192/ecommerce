$(document).ready(function(){
    fetchData();
})

/**
 * Main Function
 */

function fetchData(){
    axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('jwt_token')}`;

    axios.get('/api/admin/home')
        .then(function (response) {
            let msg = response['data']['msg']
            let data = response['data']['data']
            $('#imageTotal h2').text(data['image_total']);
            $('#adminTotal h2').text(data['admin_total']);
            $('#productTotal h2').text(data['product_total']);
            $('#categoryTotal h2').text(data['category_total']);
        })
        .catch(function (error) {
            let code = error.response.data.code
            let msg = error['response']['data']['msg']
            if(code == 401){
                window.location.href = "/admin/auth/login"
            }else{
                serverErrorSwal()
            }
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
