$(document).ready(function () {
    document.getElementById("search-button").addEventListener("click", goTo);
    var input = document.getElementById("searchbar");
    input.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            document.getElementById("search-button").click();
        }
    });
    function goTo() {
        var result = document.getElementById("searchbar").value;
        window.location.href = '/client/search/'+result;
    }
})

$( document ).ready(function() {
    $( "#product-mobile" ).keyup(function() {
        let value = $(this).val()
        if(!value){
            $("#product-result-mobile").empty()
            $("#product-result-mobile").append(emptyData())
        }else{
            $.ajax({
                type: 'GET',
                url: `/client/product/mobile/${value}`,
                success: function(response){
                    let data = response.data
                    if(!data){
                        $("#product-result-mobile").empty()
                        $("#product-result-mobile").append(emptyData())
                    }else{
                        let keyword = response['data']['product_keyword']
                        let total = response['data']['product_total']
                        let dataProduct = response['data']['product_data']
                        $("#product-result-mobile").empty()
                        $("#product-result-mobile").append(availableData(total,keyword,dataProduct))
                    }
                },
                error: emptyData()
            });
        }
    });
});

function emptyData(){
    let html = `<div class="search-result-header">
            </div>
            <div class="psearch-results">
                <div class="card-body text-center">
                    <h5>Tidak ada produk ditemukan</h5>
                </div>
            </div>`

    return html
}

function availableData(total, keyword, data) {

    const rupiah = (number)=>{
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            decimal: 0
        }).format(number);
    }

    let imageUrl = data[0]['product_image']
    let productName = data[0]['product_name']
    let secondImageUrl = data[1]['product_image']
    let secondProductName = data[1]['product_name']
    let productPrice = rupiah(data[0]['product_price'])
    let secondProductPrice = rupiah(data[1]['product_price'])
    let productId = data[0]['product_id']
    let secondProductId = data[1]['product_id']

    let html = `<div class="search-result-header">
                <h6 class="title">${total} data ditemukan</h6>
                <a href="/client/search/${keyword}" class="view-all">Lihat Semua</a>
            </div>
            <div class="psearch-results">
                    <div class="axil-product-list">
                    <div class="thumbnail">
                        <a href="/client/product/${productId}">
                            <img src="/assets/images/product/${imageUrl}" alt="${productName}">
                        </a>
                    </div>
                    <div class="product-content">

                        <h6 class="product-title"><a href="/client/product/${productId}">${productName}</a></h6>
                        <div class="product-price-variant">
                            <span class="price current-price">${productPrice}</span>
                        </div>
                        <div class="product-cart">
                            <a href="https://api.whatsapp.com/send?phone=6281221569002&text=Halo%20saya%20mau%20beli%20${productName}" class="cart-btn"><i class="fal fa-shopping-cart"></i></a>
                            <a href="#" class="cart-btn"><i class="fal fa-heart"></i></a>
                        </div>
                    </div>
                </div>
                    <div class="axil-product-list">
                    <div class="thumbnail">
                        <a href="/client/product/${secondProductId}">
                            <img src="/assets/images/product/${secondImageUrl}" alt="${secondProductName}">
                        </a>
                    </div>
                    <div class="product-content">

                        <h6 class="product-title"><a href="/client/product/${secondProductId}">${secondProductName}</a></h6>
                        <div class="product-price-variant">
                            <span class="price current-price">${secondProductPrice}</span>
                        </div>
                        <div class="product-cart">
                            <a href="https://api.whatsapp.com/send?phone=6281221569002&text=Halo%20saya%20mau%20beli%20${secondProductName}" class="cart-btn"><i class="fal fa-shopping-cart"></i></a>
                            <a href="#" class="cart-btn"><i class="fal fa-heart"></i></a>
                        </div>
                    </div>
                </div>
            </div>`

    return html
}
