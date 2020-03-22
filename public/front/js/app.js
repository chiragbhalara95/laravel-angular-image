
var BASE_URL = 'http://localhost/laravel-angular-image/public/api/v1';
var API_TOKEN = readCookie('user_api_token');
$( document ).ready(function() {
    calculatePrice();
});

/*
window.setTimeout(function() {
    $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
        $(this).addClass('hide'); 
    });
}, 5000);
*/

/**
 * Add items to cart
 * @param id
 */
function addToCart(id) {
    var token = readCookie('user_token');
    $.ajax({
        url:  BASE_URL + "/cart",
        type: "POST",
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        data: {
            product_id: id,
            token: token,
            api_token: API_TOKEN
        },
        success: function(response) {
            status = response.status;
            if(status != 201) {
                error_message = (response.errors[0]['parameter'] != '' ? response.errors[0]['parameter'] : response.errors[0]['message']);
                $('#notify-' + id).addClass('alert-warning').show().append(error_message);
            } else {
                /*
                $('#notify-' + id+' #notify-msg').remove();
                //$('#add-cart-' + id).addClass('disabled');
                $('#notify-' + id).addClass('alert-success').show().append('Added!');
                */
                $('#notify-' + id+' #notify-msg').remove();
                $('#notify-' + id).addClass('alert-success').show();
                $('#notify-' + id).html("<p id='notify-msg'>Added</p>");
            }
        },
        error: function(xhr) {
            console.log(xhr)
            console.log('there is error');
        }
    });
}

/**
 * Calculate the total price and grand total price
 * @param unit_price
 * @param product_id
 */
function calculatePrice(unit_price, product_id) {
    var qty = $('#qty-' + product_id).val();
    $('#total-' + product_id).html(qty * unit_price);

    // Update grand total
    updateGrandTotal();
}

/**
 * Remove item from cart
 * @param int id
 */
function removeFromCart(id) {
    var token = readCookie('user_token');
    $.ajax({
        url:  BASE_URL + "/cart/" + id,
        type: "DELETE",
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        data: {
            token: token,
            api_token: API_TOKEN
        },
        success: function(response) {
            var status = response.status;
            if(status == 200) {
                $( "#item-" + id ).remove();
                updateGrandTotal();
            } else {
                alert('There are some error processing request');
            }
        },
        error: function(xhr) {
            console.log(xhr)
            console.log('there is error');
        }
    });
}
/**
 * Update grand total
 */
function updateGrandTotal() {
    var total = 0;
    $('[id^=total-]').each(function(index, value) {
        var product_id = value.id.split("-")[1];
        var unit_price = $('#qty-' + product_id).val();
        var qty = parseInt($('#unit-' + product_id).innerHTML);
        total += parseInt(this.innerHTML);
        $('#grand-total').html(qty * unit_price);
    });

    $('#grand-total').html('$'+total);
}

/**
 * Read cookie value
 * @param string name
 * @returns {*}
 */
function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
