$(document).ready(function() {
    // Cart
    $('#cart').click(function() {
        $('.cart-drop').addClass('active-cart');
        $('.layer').addClass('active-layer');
    })
    $('.layer').click(function() {
        $('.cart-drop').removeClass('active-cart');
        $('.layer').removeClass('active-layer');
    })
});