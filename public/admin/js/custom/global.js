$( document ).ready(function() {
    topbarNotification()
    topbarProfile()
});

function topbarProfile(){
    $.ajax({
        type: "GET",
        url: "/api/admin/profile",
        headers: {
            Authorization: `Bearer` + `${localStorage.getItem("jwt_token")}`
        },
        success: function (result, status, xhr) {
            let userImage = ''
            let name = result['data']['name']
            let image = result['data']['image']
            let level = result['data']['level']

            if(image == null){
                userImage = 'admin.png'
            }else{
                userImage = image
            }

            $("#topbar-profile").empty()
            $("#topbar-profile").append(htmlTopbarProfile(name,userImage,level))

        },
        error: function (xhr, status, error) {
            let responseCode = xhr.status
            if(responseCode = 401){
                window.location.href = "/admin/auth/login"
            }else if(responseCode = 404){
                window.location.href = "/admin/auth/login"
            }else{
                alert("Internal server error")
            }
        }
    });
}

function topbarNotification(){
    $.ajax({
        type: "GET",
        url: "/api/admin/notification",
        headers: {
            Authorization: `Bearer` + `${localStorage.getItem("jwt_token")}`
        },
        success: function (result, status, xhr) {
            let totalNotification = result['data']['total_notification']
            let data = result['data']['data']
            $("#topbar-total-notification").empty()
            $("#topbar-total-notification").text(totalNotification)
            $("#topbar-notification").empty()
            for(let i in data){
                let image = data[i]["notification_image"]
                let content = data[i]["notification_message"]
                let time = data[i]["created_at"]
                $("#topbar-notification").append(htmlTopbarNotification(image,content,time))
            }
        },
        error: function (xhr, status, error) {
            let responseCode = xhr.status
            if(responseCode = 401){
                window.location.href = "/admin/auth/login"
            }else if(responseCode = 404){
                window.location.href = "/admin/auth/login"
            }else{
                alert("Internal server error")
            }
        }
    });
}

function htmlTopbarNotification(image,content,time){
    let html = `<li>
                                        <div class="timeline-panel">
                                            <div class="media mr-2">
                                                <img alt="image" width="50" src="/admin/images/notification/${image}">
                                            </div>
                                            <div class="media-body">
                                                <h6 class="mb-1">${content}</h6>
                                                <small class="d-block">${time}</small>
                                            </div>
                                        </div>
                                    </li>`
    return html
}

function htmlTopbarProfile(name,image,level){
    let html = `<img src="/admin/images/avatar/${image}" width="20" alt="" class="rounded-circle"/>
                            <div class="header-info">
                                <span>${name}</span>
                                <small>${level}</small>
                            </div>
                            <i class="fa fa-caret-down ml-3 mr-2 " aria-hidden="true"></i>`
    return html
}

function logout(){
    $.ajax({
        type: "GET",
        url: "/api/auth/logout",
        headers: {
            Authorization: `Bearer` + `${localStorage.getItem("jwt_token")}`
        },
        success: function (result, status, xhr) {
            let msg = result['msg']
            defaultSuccessLogout(msg)
        },
        error: function (xhr, status, error) {
            let responseCode = xhr.status
            if(responseCode = 401){
                window.location.assign("/admin/auth/login")
            }else if(responseCode = 404){
                window.location.assign("/admin/auth/login")
            }else{
                alert("Internal server error")
            }
        }
    });
}

function defaultSuccessLogout(msg){
    Swal.fire({
        position: 'mid-end',
        icon: 'success',
        title: 'Berhasil Logout',
        text: msg + ". Mohon tunggu anda akan diarahkan ke halaman login",
        showConfirmButton: false,
        timer: 1500
    }).then(function(){
        window.location.href = "/admin/auth/login";
    })
}
