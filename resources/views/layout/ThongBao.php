<?php
function alert($type, $message) {
    $bs_class = ($type == "success") ? "alert-success" : "alert-danger";
    echo <<<alert
    <div class="alert $bs_class alert-dismissible fade show" role="alert" style="position: fixed; top: 70px; right: 25px; z-index: 9999;" id="myAlert">
    <strong class="me-3">$message</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    alert;
}
?>

<script>
// JavaScript
document.addEventListener("DOMContentLoaded", function() {
    var myAlert = document.getElementById("myAlert");
    
    // Hiển thị thông báo
    myAlert.style.display = "block";
    
    // Tự đóng thông báo sau 2 giây
    setTimeout(function() {
        myAlert.style.display = "none";
    }, 2000); // Thời gian tính bằng mili giây (ở đây là 2 giây)
});
</script>