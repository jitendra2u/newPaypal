<?php
    /*
        * Home Page - has Sample Buyer credentials, Camera (Product) Details and Instructions for using the code sample
    */

    include('header.php');
?>
    <style>
        tr{
            line-height:30px;
        }
        td{
            padding:5px;
        }
    </style>
    <div class="row">
        <div class="col-md-3">
            <div>
                <img src="img/camera.jpg" width="200" height="150"/>
            </div>
            <h3>Digital SLR Camera </h3>
            <br/><br/>
            <table class="table table-striped">
                <tr><td colspan="2"><h4> Sample Sandbox Buyer Credentials:</h4></td></tr>
                <tr><th>Buyer Email</th><th>Password</th></tr>
                <tr><td>jack_potter@buyer.com</td><td>123456789</td></tr>
                <tr><td>jen_jones@buyer.com</td><td>qwer1234</td></tr>
                <tr><td>jack_chase@buyer.com</td><td>qwer1234</td></tr>
            </table>
        </div>

        <div class="col-md-3">
            <h3> Pricing Details </h3>
            <form action="startPayment.php" method="POST">
                 <input type="text" name="csrf" value="<?php echo($_SESSION['csrf']);?>" hidden readonly/>
                 <table>
                    <!-- Item Details -->
                     <tr><td>Camera </td><td><input class="form-control" type="text" name="camera_amount" value="300" readonly/></td></tr>
                     <tr><td>Currency</td><td>
                        <input class="form-control" name="currencyCodeType" value="USD" readonly/>
                     </td></tr>
                 </table>
                <br/>
            </form>

            <form action="shipping.php" method="GET">
                <tr><td ><input type="submit"  value="Proceed to Checkout"  class="btn btn-primary btn-large" name="checkout"/></input></td></tr>
            </form>
        </div>

        <div class="col-md-6">
            <h4> README: </h4>
            <h5>BEFORE YOU GET STARTED:</h5>
            This code sample shows the Braintree SDK Demo for Hosted Fields and Checkout with PayPal. <br>For steps on Hosted Fields integration refer <a href="#hostedFields">'Braintree Hosted Fields integration steps'</a> below. And for Checkout with PayPal refer  <a href="#expresscheckout">'Checkout with PayPal integration steps'</a> below.
            <br>
            <h5> PRE-READ: </h5>
            <p>
              1) Click on ‘Proceed to Checkout’ button.<br>
              2) You will land on the Checkout page. Here, you can choose either Credit Card payment option or the 'Checkout with PayPal' option.<br>
              3) For Credit Card payment, fill in the necessary details and click 'Pay with Card'. Sample card details are present in the Card field placeholders. You will see the Payment confirmation page.<br>
              4) For Checkout with PayPal, click on the 'Checkout with PayPal' button. Log In with PayPal Sandbox email and password credentials. Sample Sandbox credentials are offered on the start page. Review the payment information and hit 'Pay Now'. You will land on the Payment confirmation page.<br>
              5) braintreeConfig.php contains sample Braintree Sandbox merchant credentials along with import for the Braintree library. You can try out your own Sandbox merchant credentials. Just replace the merchantId, publicKey and privateKey in braintreeConfig.php with your Braintree Sandbox Merchant credentials and complete the payment.<br>
              6) For information on accepting PayPal with Braintree, refer the <a href="https://articles.braintreepayments.com/support/guides/payment-methods/paypal/setup-guide" target="_blank">Setup Guide</a>.
              </p>
               <h4 id="hostedFields"> Hosted Fields integration steps: </h4>
                    1) You can learn about the Hosted Fields <a href="https://developers.braintreepayments.com/guides/hosted-fields/overview/javascript/v3" target="_blank">here</a>.<br>
                    2) Refer the 'Load the required Braintree client component' and 'Hosted Fields for Credit Card Payment' sections in HTML and the 'Braintree - Hosted Fields component' in the JavaScript on the checkout.php code to understand how to create the Hosted Fields.<br>
                    3) The final Transaction sale call is present in payment.php in 'Make the Braintree call to execute the payment.' section. Refer <a href ="https://developers.braintreepayments.com/reference/request/transaction/sale/php" target="_blank">Braintree_Transaction::sale()</a> for additional information.<br>
                    4) Basic Structure of the Hosted Fields script component: <pre><code>
braintree.client.create({
    authorization: 'CLIENT_AUTHORIZATION'
    }, function (clientErr, clientInstance) {
        if (clientErr) {
        // Handle error in client creation
        return;
        }

        var options = {
            client: clientInstance,
            styles: {
            /* ... */
            },
            fields: {
            /* ... */
        }
    };

    braintree.hostedFields.create(options, function (hostedFieldsErr, hostedFieldsInstance) {
            if (hostedFieldsErr) {
                // Handle error in Hosted Fields creation
                return;
            }

        // Use the Hosted Fields instance here to tokenize a card
    });
});</code></pre><br>
                    5) Please detailed information, read the Braintree documentation for integrating <a href="https://developers.braintreepayments.com/guides/hosted-fields/setup-and-integration/javascript/v3" target="_blank">Hosted Fields </a>.<br>
            <br><br>
                <h4 id="expresscheckout"> Checkout with PayPal integration steps: </h4>
                          1) Refer the 'Load the required Braintree client component' and 'Braintree - PayPal button component' sections in the checkout.php for rendering 'Checkout with PayPal' button and associating a payment with it.<br>
                          2) The final Transaction sale call is present in payment.php in 'Make the Braintree call to execute the payment.' section. Refer <a href ="https://developers.braintreepayments.com/reference/request/transaction/sale/php" target="_blank">Braintree_Transaction::sale()</a> for additional information.<br>
                          3) Basic Client Side script structure for Checkout with PayPal button and payment:
<pre><code>// Be sure to have checkout.js loaded on your page.
&lt;script src=&quot;https://www.paypalobjects.com/api/checkout.js&quot; data-version-4 log-level=&quot;warn&quot;&gt;&lt;/script&gt;

braintree.paypalCheckout.create({
    client: clientInstance
    }, function (createErr, paypalCheckoutInstance) {
        if (createErr) {
            if (createErr.code === 'PAYPAL_BROWSER_NOT_SUPPORTED') {
                console.error('This browser is not supported.');
            } else {
                console.error('Error!', createErr);
            }
            return;
        }

        paypal.Button.render({
            env: 'production', // or 'sandbox'

            locale: 'en_US',

            payment: function () {
                return paypalCheckoutInstance.createPayment({
                flow: 'vault'
            });
        },

        onAuthorize: function (data, actions) {
            return paypalCheckoutInstance.tokenizePayment(data).then(function (payload) {
            // Submit payload.nonce to your server
            });
        },

        onCancel: function (data) {
            console.log('checkout.js payment cancelled', JSON.stringify(data, 0, 2));
        },

        onError: function (err) {
            console.error('checkout.js error', err);
        }
    }, '#paypal-button'); // the PayPal button will be rendered in an html element with the id `paypal-button`
});</code></pre><br>
                            4) To learn about how to create a payment with Checkout with PayPal button refer <a href ="https://braintree.github.io/braintree-web/current/module-braintree-web_paypal-checkout.html#.create" target="_blank">this link</a>.<br>
            <br>
        </div>
    </div>

<?php
     include('footer.php');
?>