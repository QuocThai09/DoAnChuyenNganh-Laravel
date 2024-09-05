<!-- Bootstrap CSS -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!-- Bootstrap JS bundle (including Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+WyWtg+Rx91eDkDShUnJKF1GIJ6lT0U6enw"
    crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/#main-contentadmin/css/common.css" />

   
<style>
    .custom-alert {
        position: fixed;
        top: 25px;
        right: 25px;
    }
</style>
<?php 
function alert($type, $message)
{
    $bs_class = ($type == "success") ? "alert-success" : "alert-danger";
    ?>
    <div class="alert <?php echo $bs_class ?> alert-dismissible fade show" role="alert" style="position: fixed; top: 70px; right: 30px; z-index: 9999;" id="myAlert">
    <strong class="me-3"><?php echo $message ?></strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php
}

if (isset($_SESSION['successMessage'])) {
    echo '<div class="alert alert-success alert-dismissible fade show custom-alert" role="alert" style="position: fixed;top: 70px; right: 25px; z-index: 9999;" id="myAlert">' .
        $_SESSION['successMessage'] .
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' .
        '</div>';
    unset($_SESSION['successMessage']); // Clear the session variable
}

if (isset($_SESSION['errorMessage'])) {
    echo '<div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert" style="position: fixed;top: 70px; right: 25px; z-index: 9999;" id="myAlert">' .
        $_SESSION['errorMessage'] .
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' .
        '</div>';
    unset($_SESSION['errorMessage']); // Clear the session variable
}

