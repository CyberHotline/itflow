<?php
/*
 * Client Portal
 * Auto-pay configuration for PTC/finance contacts
 */

require_once "inc_portal.php";

if ($session_contact_primary == 0 && !$session_contact_is_billing_contact) {
    header("Location: portal_post.php?logout");
    exit();
}

// Initialize stripe
require_once '../vendor/stripe-php-10.5.0/init.php';

// Get Stripe vars
$stripe_vars = mysqli_fetch_array(mysqli_query($mysqli, "SELECT config_stripe_enable, config_stripe_publishable, config_stripe_secret FROM settings WHERE company_id = 1"));
$config_stripe_enable = intval($stripe_vars['config_stripe_enable']);
$config_stripe_publishable = nullable_htmlentities($stripe_vars['config_stripe_publishable']);
$config_stripe_secret = nullable_htmlentities($stripe_vars['config_stripe_secret']);

// Get client's StripeID from database
$stripe_client_details = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM client_stripe WHERE client_id = $session_client_id LIMIT 1"));
if ($stripe_client_details) {
    $stripe_id = sanitizeInput($stripe_client_details['stripe_id']);
    $stripe_pm = sanitizeInput($stripe_client_details['stripe_pm']);
}

// Stripe not enabled in settings
if (!$config_stripe_enable || !$config_stripe_publishable || !$config_stripe_secret) {
    echo "Stripe payment error - Stripe is not enabled, please talk to your helpdesk for further information.";
    include_once 'portal_footer.php';
    exit();
}

?>

    <h3>AutoPay</h3>
    <div class="row">

        <div class="col-md-10">

            <!-- Setup pt1: Stripe ID not found / auto-payment not configured -->
            <?php if (!$stripe_client_details || empty($stripe_id)) { ?>

                <b>Save card details</b><br>
                In order to set up automatic payments, you must create a customer record in Stripe.<br>
                First, you must authorize Stripe to store your card details for the purpose of automatic payment.
            <br><br>

                <div class="col-5">
                    <form action="portal_post.php" method="POST">

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="consent" name="consent" value="1" required>
                                <label for="consent" class="custom-control-label">
                                    I grant consent for automatic payments
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="form-control btn-success" name="create_stripe_customer">Create Stripe Customer Record</button>
                        </div>
                    </form>
                </div>

            <?php }

            // Setup pt2: Stripe ID found / payment may be configured -->
            elseif (empty($stripe_pm)) { ?>

                <b>Save card details</b><br>
                Please add the payment details you would like to save.<br>
                By adding payment details here, you grant consent for future automatic payments of invoices.<br><br>

                <script src="https://js.stripe.com/v3/"></script>
                <script src="../js/autopay_setup_stripe.js"></script>
            <input type="hidden" id="stripe_publishable_key" value="<?php echo $config_stripe_publishable ?>">
                <div id="checkout">
                    <!-- Checkout will insert the payment form here -->
                </div>

            <?php }

            // Manage the saved card
            else { ?>

                <b>Manage saved card details</b>

                <?php

                // Initialize
                $stripe = new \Stripe\StripeClient($config_stripe_secret);

                $payment_method = $stripe->customers->retrievePaymentMethod(
                    $stripe_id,
                    $stripe_pm,
                    []
                );

                $card_name = nullable_htmlentities($payment_method->billing_details->name);
                $card_brand = nullable_htmlentities($payment_method->card->display_brand);
                $card_last4 = nullable_htmlentities($payment_method->card->last4);
                $card_expires = nullable_htmlentities($payment_method->card->exp_month) . "/" . nullable_htmlentities($payment_method->card->exp_year);

                ?>

                <ul><li><?php echo "$card_name - $card_brand card ending in $card_last4, expires $card_expires"; ?></li></ul>

                <hr>
                <b>Actions</b><br>
                - <a href="portal_post.php?stripe_remove_card&pm=<?php echo $stripe_pm; ?>">Remove saved card</a>

            <?php } ?>


        </div>

    </div>


<?php
require_once "portal_footer.php";
