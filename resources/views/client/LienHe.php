<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đồ Án Khách Sạn</title>
    <?php require('link.php'); ?>
</head>
<body bg-light>

    <?php require('Header.php'); ?>
    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">LIÊN HỆ</h2>
        <div class="bg-dark" style="width: 150px; height: 1.7px; margin: 0 auto;"></div>
        <p class="text-center mt-3">
            <h3 class="text-center">HỖ TRỢ THẮC MẮC CỦA BẠN</h3><br>
            <p class="text-center">Nếu bạn có thắc mắc về khách sạn hoặc các vấn đề về lưu trú, vui lòng gửi thắc mắc về hộp thư của chúng tôi.<br>Chúng tôi sẽ phản hồi lại bạn ngay khi nhận được thông tin.</p>
        </p>
    </div>

    <div class="contaner">
        <div class="row">
            <div class="col-lg-6 col-md-6 mb-5 px-4">
                <div class="bg-white shadow p-4">
                    <iframe class="w-100 mb-4" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.0672268557546!2d106.62607571110689!3d10.806163158599073!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752be27d8b4f4d%3A0x92dcba2950430867!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBDw7RuZyBUaMawxqFuZyBUUC4gSOG7kyBDaMOtIE1pbmg!5e0!3m2!1svi!2s!4v1698835365757!5m2!1svi!2s" height="320px" loading="lazy"></iframe>
                    <h5>Địa Chỉ</h5>
                    <i class="bi bi-compass"></i> 140 Lê Trọng Tấn, Tây Thạnh, Tân Phú, Thành phố Hồ Chí Minh
                    <h5 class="mt-4">Gọi Cho Chúng Tôi</h5>
                    <a href="tel: 0702025375" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i>  0702025375
                    </a>
                    <br>
                    <a href="tel: 0702025375" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i>  0702025375
                    </a>
                    <h5 class="mt-4">Email</h5>
                    <a><i class="bi bi-envelope-fill"></i> hoangthanh8003@gmail.com</a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-5 px-4">
                <div class="bg-white shadow p-4">
                    <form>
                        <h5>Gửi Thông Tin</h5>
                        <div class="mt-3">
                            <label class="form-label">Họ Tên</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label class="form-label">Nội Dung</label>
                            <textarea class="form-control shadow-none" rows="7" style="resize: none;"></textarea>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-dark mt-3 col-lg-4">GỬI HỖ TRỢ</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


    

    <?php require('Footer.php') ?>
    

</body>
</html>