<?php

require_once '../includes/ajax_header.php';

$login_id = intval($_GET['id']);

$sql = mysqli_query($mysqli, "SELECT * FROM logins WHERE login_id = $login_id LIMIT 1");
                     
$row = mysqli_fetch_array($sql);
$login_name = nullable_htmlentities($row['login_name']);
$login_description = nullable_htmlentities($row['login_description']);
$login_uri = nullable_htmlentities($row['login_uri']);
$login_uri_2 = nullable_htmlentities($row['login_uri_2']);
$login_username = nullable_htmlentities(decryptLoginEntry($row['login_username']));
$login_password = nullable_htmlentities(decryptLoginEntry($row['login_password']));
$login_otp_secret = nullable_htmlentities($row['login_otp_secret']);
$login_id_with_secret = '"' . $row['login_id'] . '","' . $row['login_otp_secret'] . '"';
if (empty($login_otp_secret)) {
    $otp_display = "-";
} else {
    $otp_display = "<span onmouseenter='showOTPViaLoginID($login_id)'><i class='far fa-clock'></i> <span id='otp_$login_id'><i>Hover..</i></span></span>";
}
$login_note = nullable_htmlentities($row['login_note']);
$login_created_at = nullable_htmlentities($row['login_created_at']);

// Generate the HTML form content using output buffering.
ob_start();
?>

<div class="modal-header bg-dark text-white">
    <div class="d-flex align-items-center">
        <i class="fas fa-fw fa-building fa-2x mr-3"></i>
        <div>
            <h5 class="modal-title mb-0"><?php echo $name; ?></h5>
            <div class="text-muted"><?php echo getFallback($description); ?></div>
        </div>
    </div>
    <button type="button" class="close text-white" data-dismiss="modal">
        <span>&times;</span>
    </button>
</div>

<div class="modal-body bg-light">

    <!-- Vendor Info Card -->
    <div class="card mb-3 shadow-sm rounded">
        <div class="card-body">
            <h6 class="text-secondary"><i class="fas fa-info-circle mr-2"></i>Vendor Details</h6>
            <div class="row">
                <div class="col-sm-6">
                    <div><strong>Account Number:</strong> <?php echo getFallback($account_number); ?></div>
                    <div><strong>Hours:</strong> <?php echo getFallback($hours); ?></div>
                    <div><strong>SLA:</strong> <?php echo getFallback($sla); ?></div>
                </div>
                <div class="col-sm-6">
                    <div><strong>Code:</strong> <?php echo getFallback($code); ?></div>
                    <div><strong>Website:</strong> <?php echo !empty($website) ? '<a href="' . $website . '" target="_blank" class="text-primary">' . $website . '</a>' : '<span class="text-muted">Not Available</span>'; ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Info Card -->
    <div class="card mb-3 shadow-sm rounded">
        <div class="card-body">
            <h6 class="text-secondary"><i class="fas fa-user mr-2"></i>Contact Information</h6>
            <div class="row">
                <div class="col-sm-6">
                    <div><strong>Contact Name:</strong> <?php echo getFallback($contact_name); ?></div>
                    <div><strong>Phone:</strong> <?php echo getFallback($phone); ?></div>
                </div>
                <div class="col-sm-6">
                    <div><strong>Email:</strong> <?php echo !empty($email) ? '<a href="mailto:' . $email . '" class="text-primary">' . $email . '</a>' : '<span class="text-muted">Not Available</span>'; ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notes Card -->
    <div class="card mb-3 shadow-sm rounded">
        <div class="card-body">
            <h6 class="text-secondary"><i class="fas fa-sticky-note mr-2"></i>Notes</h6>
            <div>
                <?php echo getFallback($notes); ?>
            </div>
        </div>
    </div>

</div>

<script src="js/credential_show_otp_via_id.js"></script>

<?php
require_once "../includes/ajax_footer.php";
