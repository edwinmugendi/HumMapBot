<!-- The required Stripe lib -->
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<!-- jQuery is used only for this example; it isn't required to use Stripe -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script type="text/javascript">
    // This identifies your website in the createToken call below
    Stripe.setPublishableKey('<?php echo \Config::get('thirdParty.stripe.api_key'); ?>');

    var stripeResponseHandler = function (status, response) {
        var $form = $('#payment-form');
        console.log(response);
        if (response.error) {
        } else {
            // token contains id, last4, and card type
            var token = response.id;
            /*
             // Insert the token into the form so it gets submitted to the server
             $form.append($('<input type="hidden" name="stripeToken" />').val(token));
             // and re-submit
             $form.get(0).submit();
             */
        }
    };

    jQuery(function ($) {


        $('#payment-form1').submit(function (e) {
            var $form = $(this);
            // Disable the submit button to prevent repeated clicks
            $form.find('button').prop('disabled', true);
           

            Stripe.card.createToken({
                number: $('.card-number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.exp-month').val(),
                exp_year: $('.exp-year').val()
            }, stripeResponseHandler);

            // Prevent the form from submitting with the default action
            return false;
        });

        $('#idSubmit').click(function ($event) {
            $event.preventDefault();
            var $form = $(this);
            // Disable the submit button to prevent repeated clicks
            $form.find('button').prop('disabled', true);
            

            Stripe.card.createToken({
                number: $('.card-number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.exp-month').val(),
                exp_year: $('.exp-year').val()
            }, stripeResponseHandler);


        });
    });
</script>
</head>
<body>
    <h1>Charge $10 with Stripe</h1>

    <form action="" method="POST" id="payment-form">
        <span class="payment-errors"></span>

        <div class="form-row">
            <label>
                <span>Card Number</span>
                <input type="text" size="20" data-stripe="number" class="card-number" value="4242424242424242"/>
            </label>
        </div>

        <div class="form-row">
            <label>
                <span>CVC</span>
                <input type="text" size="4" data-stripe="cvc" class="card-cvc" value="123"/>
            </label>
        </div>

        <div class="form-row">
            <label>
                <span>Expiration (MM/YYYY)</span>
                <input type="text" size="2" data-stripe="exp-month" class="exp-month" value="12"/>
            </label>
            <span> / </span>
            <input type="text" size="4" data-stripe="exp-year" class="exp-year" value="2020"/>
        </div>

        <button id="idSubmit">Submit Payment</button>
    </form>
