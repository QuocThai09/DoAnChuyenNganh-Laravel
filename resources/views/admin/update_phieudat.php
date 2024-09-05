<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require('C:/xampp/htdocs/mail/PHPMailer-master/src/Exception.php');
require('C:/xampp/htdocs/mail/PHPMailer-master/src/SMTP.php');
require('C:/xampp/htdocs/mail/PHPMailer-master/src/PHPMailer.php');


$maphieu = $_POST['MAPHIEUDATPHONG'];
$sophong = $_POST['SOPHONG'];
$tenKH = $_POST['HOTENKH'];
$ngaydat = $_POST['NGAYDATPHONG'];
$ngaytra = $_POST['NGAYTRAPHONG'];
$ngaynhan = $_POST['NGAYNHANPHONG'];
$loaiphong = $_POST['TENLOAIPHONG'];

require_once 'ketnoi.php';

$updatesql = "UPDATE `phieudatphong` SET `SOPHONG`='$sophong' WHERE `MAPHIEUDATPHONG`='$maphieu'";
$updatePhong = "UPDATE `phong` SET `TRANGTHAIPHONG`= 1 WHERE `SOPHONG`='$sophong'";
mysqli_query($conn,$updatePhong);
if (mysqli_query($conn, $updatesql)) {
    $_SESSION['successMessage'] = "Xác nhận phòng thành công.";

    $mail = new PHPMailer(true);
    try {
    //Server settings
    $mail->SMTPDebug = 0;
    $mail->isSMTP(); // Sử dụng SMTP để gửi mail
    $mail->Host = 'smtp.gmail.com'; // Server SMTP của gmail
    $mail->SMTPAuth = true; // Bật xác thực SMTP
    $mail->Username = 'quanlykhachsan09@gmail.com'; // Tài khoản email
    $mail->Password = 'wjpwtjvuymlidctx'; // Mật khẩu ứng dụng ở bước 1 hoặc mật khẩu email
    $mail->SMTPSecure = 'ssl'; // Mã hóa SSL
    $mail->Port = 465; // Cổng kết nối SMTP là 465

    //Recipients
    $mail->setFrom('quanlykhachsan09@gmail.com', 'Hotel TVT'); // Địa chỉ email và tên người gửi
    $mail->addAddress('daoquocthai09@gmail.com', 'Đào Quốc Thái'); // Địa chỉ mail và tên người nhận

    //Content
    $mail->isHTML(true); // Set email format to HTML
    //$mail->Subject = 'Xác nhận đơn đặt phòng'; 
    $subject = 'Xác nhận đặt phòng khách sạn TVT';
    $sub = '=?UTF-8?B?'.base64_encode($subject).'?=';
    $mail->Subject = $sub;// Tiêu đề
    $mail->Body = "
        Kính gửi <b>$tenKH</b>,<br>
        Chúng tôi rất vui mừng cho kỳ nghỉ sắp tới của bạn tại Khách sạn TVT.
         Xin nhắc lại, số phòng của bạn là <b>$sophong</b> thời gian nhận phòng là <b>$ngaynhan</b> và trả phòng là <b>$ngaytra</b>.<br>
        Xin lưu ý rằng Wi-Fi miễn phí được cung cấp cho tất cả các khách và chỗ đỗ xe được cung cấp có tính phí ngay trong khuôn viên.
        Một số điểm tham quan và nhà hàng gần đó bao gồm Nhà hàng ABC, bãi biển và còn nhiều nơi thú vị khác, .. và khách sạn của chúng tôi cung cấp: <br>
        - Dịch vụ giặt ủi quần áo.<br>
        - Dịch vụ xe đưa đón sân bay.<br>
        - Nhà hàng.<br>
        - Quầy bar.<br>
        - Dịch vụ Spa.<br>
        Nếu bạn có bất kỳ câu hỏi hoặc yêu cầu đặc biệt nào, vui lòng liên hệ với chúng tôi theo số 0912345678.<br>
        Cảm ơn bạn, và chúng tôi mong sớm gặp lại bạn.
        Trân trọng, <b>$tenKH</b>.
    "; // Nội dung

    $mail->send();
    echo 'Message has been sent';
    } catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;}

    header("Location: DSPhieuDatPhong.php");
} else {
    $_SESSION['errorMessage'] = "Lỗi: " . mysqli_error($conn);
    header("Location: DSPhieuDatPhong.php");
}
?>