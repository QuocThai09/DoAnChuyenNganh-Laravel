<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbs5rBQe7i7uCA2ek3IjYqMOSh5P2n/RV+jqk9Je8fZcFAF5w5nEJX5DO2aFZ" crossorigin="anonymous">

<!-- Bootstrap JS bundle (including Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+WyWtg+Rx91eDkDShUnJKF1GIJ6lT0U6enw"
    crossorigin="anonymous"></script>
<link rel="stylesheet" href="/#main-contentadmin/css/common.css">

<style>
    .custom-alert {
        position: fixed;
        top: 25px;
        right: 25px;
    }
</style>
<?php
if(!isset($_SESSION)){
    session_start();
}

function alert($type, $message)
{
    $bs_class = ($type == "success") ? "alert-success" : "alert-danger";
    echo <<<alert
    <div class="alert $bs_class alert-dismissible fade show" role="alert" style="position: fixed; top: 70px; right: 25px; z-index: 9999;" id="myAlert">
    <strong class="me-3">$message</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    alert;
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

?>
<script>
// JavaScript
document.addEventListener("DOMContentLoaded", function() {
    var myAlert = document.getElementById("myAlert");
    
    // Hiển thị thông báo
    myAlert.style.display = "block";
    
    //Tự đóng thông báo từ từ sau 2 giây
    var opacity = 1;
    var interval = setInterval(function() {
        opacity -= 0.05;
        myAlert.style.opacity = opacity;
        if (opacity <= 0) {
            clearInterval(interval);
            myAlert.style.display = "none";
        }
    }, 200);
});
</script>