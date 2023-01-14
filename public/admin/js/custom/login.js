$(document).ready(function () {

    let csrfToken = $('meta[name="csrf-token"]').attr('content')

    $('#btn-submit').keypress(function(e){
        if(e.which == 13){//Enter key pressed
            $('#btn-submit').click();
        }
    });

    $('#username').keypress(function(e){
        if(e.which == 13){//Enter key pressed
            $('#btn-submit').click();
        }
    });

    $('#password').keypress(function(e){
        if(e.which == 13){//Enter key pressed
            $('#btn-submit').click();
        }
    });

    $("#btn-submit").click(function (event) {
        let formData = {
            username: $("#username").val(),
            password: $("#password").val(),
        };

        axios.defaults.headers['x-csrf-token'] = csrfToken

        axios.post('/api/auth/login', formData)
            .then(function (response) {
                let msg = response['data']['msg']
                let token = response['data']['data']['token']
                localStorage.clear()
                localStorage.setItem("jwt_token",token)
                defaultSuccessSwal(msg,token)
            })
            .catch(function (error) {
                let code = error.response.data.code
                let msg = error['response']['data']['msg']
                if(code == 401){
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Login',
                        text: msg,
                    })
                }else if(code == 400){
                    let parseData = JSON.parse(msg)
                    let usernameErr = parseData['username']
                    let passwordErr = parseData['password']
                    if(usernameErr != null){
                        loopSwal(usernameErr)
                    }else if(passwordErr != null){
                        loopSwal(passwordErr)
                    }else{
                        defaultErrSwal()
                    }
                }else{
                    defaultErrSwal()
                }
            });

        event.preventDefault();
    });
});

function loopSwal(data) {
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

function defaultErrSwal(){
    Swal.fire({
        icon: 'error',
        title: 'Internal Server Error',
        text: 'Terjadi kesalahan tidak terduga ! Silahkan coba lagi',
    })
}

function defaultSuccessSwal(msg,token){
    Swal.fire({
        position: 'mid-end',
        icon: 'success',
        title: 'Berhasil Login',
        text: msg + ". Mohon tunggu anda akan diarahkan ke halaman utama",
        showConfirmButton: false,
        timer: 1500
    }).then(function(){
        window.location.href = "/admin/home";
    })
}
