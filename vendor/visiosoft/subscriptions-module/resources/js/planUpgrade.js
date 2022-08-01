$('button[data-type="paddle"]').on('click', function () {
    if ($(this).data('plan')) {
        Paddle.Checkout.open({
            product: $(this).data('plan'),
            passthrough: {'subscription_id': $(this).data('subscription')},
            email: auth_email,
            successCallback: "checkoutComplete",

        });
    }
});

function checkoutComplete(data) {
    $('#created-subscription-modal').modal('toggle');
}
