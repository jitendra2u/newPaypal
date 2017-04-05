<?php
/*
    * Successful Payment Confirmation Page
*/

include('header.php');
require_once 'braintreeConfig.php';


/* Use payment method nonce here */
if(isset($_GET['payment_method_nonce'])){
    $total = '300';
    $firstName = $_GET["first_name"];
    $lastName = $_GET["last_name"];
    $addressLine1= $_GET['line1'];
    $addressLine2 = $_GET['line2'];
    $city= $_GET['city'];
    $state= $_GET['state'];
    $postalCode = $_GET['postal_code'];
    $countryCode= $_GET['country_code'];
    $currencyCode = 'USD';
    $nonce = $_GET['payment_method_nonce'];

}

/* Make the Braintree call to execute the payment. */
$result = Braintree_Transaction::sale(array(
    'amount' => $total,
    'channel'=> 'PP-DemoPortal-BT-HF_PP-php',
    'paymentMethodNonce' => $nonce,
    'customer' => array(
        'firstName' => $firstName,
        'lastName' => $lastName,
    ),
    'shipping' => array(
        'firstName' => $firstName,
        'lastName' => $lastName,
        'streetAddress' => $addressLine1,
        'extendedAddress' => $addressLine2,
        'locality' => $city,
        'region' => $state,
        'postalCode' => $postalCode,
        'countryCodeAlpha2' => $countryCode
    )
));
?>

<!--Display Payment Confirmation-->
<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <h4>
            <?php echo($firstName.' '.$lastName.', Thank you for your Order!');?><br/><br/>
            Shipping Address: </h4>
        <?php echo($firstName.' '.$lastName);?><br/>
        <?php echo($addressLine1);?><br/>
        <?php if(!empty($addressLine2)){echo($addressLine2);?><br/><?php } ?>
        <?php echo($city);?><br/>
        <?php echo($state.'-'.$postalCode);?><br/>
        <?php echo($countryCode);?><br/>

        <h4>Transaction ID : <?php echo($result->transaction->id);?> <br/>
            State : Approved  <br/>
            Total Amount: <?php echo($total);?> &nbsp;<?php echo($currencyCode); ?> <br/>
        </h4>
        <br/>
        Return to <a href="index.php">home page</a>.
    </div>
    <div class="col-md-4"></div>
</div>


<?php
include('footer.php');
?>
