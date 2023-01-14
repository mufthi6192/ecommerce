

<script>

    $( document ).ready(function() {
        console.log( "ready!" );
    });

    $(document).ready(function () {
        $.get("/client/category/all-data", function(response){
            data = response["data"]
            for( let i in data ){
                Object.keys(data[i]).forEach(function(key) {
                    console.log('Key : ' + key + ', Value : ' + data[i][key])
                })
            }

            // console.log()
        })
        // var objXMLHttpRequest = new XMLHttpRequest();
        // objXMLHttpRequest.onreadystatechange = function() {
        //     if(objXMLHttpRequest.readyState === 4) {
        //         if(objXMLHttpRequest.status === 200) {
        //             var response = JSON.parse(objXMLHttpRequest.responseText)
        //             console.log(response["data"])
        //             alert(response)
        //         } else {
        //
        //         }
        //     }
        // }
        // objXMLHttpRequest.open('GET', '/client/category/all-data');
        // objXMLHttpRequest.send();
    })

</script>
