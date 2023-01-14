$(document).ready(function () {
    let keyword = metaFunction()
    let fullUrl = '/client/category/find/'+keyword

    $('#pagination-container').pagination({
        dataSource: function(done){
            $.ajax({
                type: 'GET',
                url: fullUrl,
                success: function(response){
                    done(response["data"]);
                }
            });
        },
        pageSize: 12,
        callback: function(data, pagination) {
            $("#list-product").empty()
            for(let i in data){
                let name = data[i]["product_name"]
                let image = data[i]["product_image"]
                let category = data[i]["product_category"]
                let price = "Rp. " + rupiah(data[i]["product_price"])
                let idProd = data[i]["product_id"]
                $("#list-product").append(renderProduct(image, category, name, price, idProd))
            }
            var html = simpleTemplating(data);
            $('#data-container').html(html);
        }
    })

    const rupiah = (number)=>{
        return new Intl.NumberFormat("id-ID", {
            style: "decimal",
            currency: "IDR",
        }).format(number);
    }

    function simpleTemplating(data) {
        var html = '<ul>';
        $.each(data, function(index, item){
            html += '<li>'+ item +'</li>';
        });
        html += '</ul>';
        return html;
    }

    function renderProduct(image,category,name,price,idProd){
        let html = `                            <div class="col-xl-3 col-lg-4 col-sm-6 col-12 mb--30 ">
                                <div class="axil-product product-style-one">
                                    <div class="thumbnail">

                                            <img  src="/assets/images/product/${image}" alt="Product Images">

                                        <div class="label-block label-right">
                                            <div class="product-badget">${category}</div>
                                        </div>
                                        <div class="product-hover-action">
                                            <ul class="cart-action">
                                                <li class="quickview"><a href="/client/product/${idProd}"><i class="far fa-eye"></i></a></li>
                                                <li class="select-option"><a href="https://api.whatsapp.com/send?phone=6281221569002&text=Halo%20saya%20mau%20beli%20${name}">Beli</a></li>
                                                <li class="wishlist"><a href="#"><i class="far fa-heart"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="inner">
                                            <h5 class="title">${name}</h5>
                                            <div class="product-price-variant">
                                                <span class="price current-price">${price}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`

        return html
    }
})


function metaFunction() {
    let meta = $("meta[name='search']").attr("content");
    return meta;
}
