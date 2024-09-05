
<?php 
    // if(!isset($_SESSION)) session_start();
    
    // if(!isset($_SESSION['admin'])){
    //     header('location:login.php');exit;
    // }
    // //unset($_SESSION['admin']);
    // require 'config/connect.php';
?>


<!DOCTYPE html>
   <html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!--=============== FAVICON ===============-->
      <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">

      <!--=============== REMIXICONS ===============-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.1.0/remixicon.min.css">

      <!--=============== CSS ===============-->
      
      <link rel="stylesheet" href="css/main.css">

      <title>Responsive cactus website - Bedimcode</title>

      <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
      <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

   </head>
   <body>
      <!--==================== HEADER ====================-->
      <header class="header" id="header">
         <nav class="container nav">
            <a href="index.php" class="nav__logo">
                <img src="./images/logo.png" alt="" style="position: relative;top: 10px;left: 20px;">
                <i>English </i>
                <p>test</p>
            </a>

            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li class="nav__item">
                        <a href="index.php" class="nav__link active-link">Trang chủ</a>
                    </li>
                    <li class="nav__item">
                        <a href="#" class="nav__link">Chứng chỉ</a>
                    </li>
                    <li class="nav__item">
                        <a href="#" class="nav__link">Danh sách đề thi</a>
                    </li>
                    
                </ul>

                <!-- Button close -->
                <div class="nav__close" id="nav-close">
                    <i class="ri-close-line"></i>
                </div>
            </div>

            <div class="nav__actions">
                <a href="trangCaNhan.php" style="text-decoration: none;color: black;"><i class="ri-user-line" style="font-size: 19px;"><?php #echo $_SESSION['admin']['hoten']?></i></a>
                <a href="logout.php" style="color: red;"><i class="ri-logout-circle-r-line" ></i></a>
                <!-- Toggle Button -->
                <div class="nav__toggle" id="nav-toggle">
                    <i class="ri-menu-line"></i>
                </div>
            </div>
         </nav>
      </header>

      <!--==================== MAIN ====================-->
      <main class="main">
         <!--==================== HOME ====================-->
         <section class="home section" id="home">
            <div class="home__container container grid">
                <img src="./images/bgIndex.jpg" class="home__img" data-aos="fade-right" data-aos-duration="500">

                <div class="home__data" data-aos="fade-left" data-aos-duration="2500">
                    <h1 class="home__title">
                        Trải nghiệm <span>ENGLISH TEST</span> <br>
                        sự lựa chọn của bạn.
                    </h1>

                    <p class="home__description" data-aos="fade-left" data-aos-duration="3000" >
                        English Test là trang website giúp bạn học tập và phát triển tiếng anh thông qua các bài tập trắc nghiệm bổ ích.
                    </p>
                    


                    <!-- <div class="home__buttons">
                        <a href="doing_test.php" class="button">
                            <span>
                                <i class="ri-arrow-right-line"></i>
                            </span>
                            Vào thi
                        </a>

                        <a href="" class="button__link">Thông tin chi tiết</a>
                    </div> -->
                </div>
            </div>
            <div style="margin-top: 100px;text-align: center;font-size: 26px;" data-aos="fade-up"  >
                <h1>Các chứng chỉ được hỗ trợ</h1>
            </div>
           
            <?php 
                // $sql = "SELECT * FROM tbl_chungchi order by machungchi";
                // $stm = $pdo->query($sql);
                // $data = $stm->fetchAll(PDO::FETCH_OBJ);
                $time = 100;
                $certificates = DB::table('certificate')->get();
                // foreach ($certificates as $item){
                //     echo $item->nameCertificate;
                // }   
            ?>
            <div style="display: flex;justify-content: center;">
                <div style="display: flex; width: 70%;justify-content: center;margin-top: 50px" >
                    <?php 
                        foreach($certificates as $item){
                            ?>
                                <div class="card" style="margin: 20px;" data-aos="fade-up"  data-aos-duration="<?php echo $time?>">
                                    <div class="card-details">
                                        <p class="text-title"><?php echo $item->nameCertificate?></p>
                                        <p class="text-body"><?php echo $item->describe?></p>
                                    </div>
                                    <a href="doing_test.php?id=<?php echo $item->id?>&nameCertificate=<?php echo $item->nameCertificate?>" class="card-button">Xem chi tiết</a>
                                </div> 
                            <?php
                            $time += 400;
                        }
                    ?>
                </div>
            </div>

            <div style="height: 100px;"></div>
         </section>
      </main>
      <br>

      <!--==================== FOOTER ====================-->
      <footer class="footer">
         <div class="footer__container container grid">
            <div>
                <a href="" class="footer__logo">
                    <i class="ri-catus-line"></i>
                </a>

                <p class="footer__description">
                    Sự lựa chọn tốt nhất <br> English Test dành cho bạn.
                </p>
            </div>

            <div class="footer__content grid">
                <div>
                    <h3 class="footer__title">Về chúng tôi</h3>

                    <ul class="footer__links">
                        <li>
                            <a href="" class="footer__link">Thông tin của chúng tôi</a>
                        </li>
                        <li>
                            <a href="" class="footer__link">Lịch sử hình thành</a>
                        </li>
                        <li>
                            <a href="" class="footer__link">Sứ mệnh và tầm nhìn</a>
                        </li>
                        <li>
                            <a href="" class="footer__link">Tin tức</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="footer__title">Dịch vụ</h3>

                    <ul class="footer__links">
                        <li>
                            <a href="" class="footer__link">Đăng ký tài khoản</a>
                        </li>
                        <li>
                            <a href="" class="footer__link">Lịch sử bài làm</a>
                        </li>
                        <li>
                            <a href="" class="footer__link">Quên mật khẩu</a>
                        </li>
                        <li>
                            <a href="" class="footer__link">Đổi mật khẩu</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="footer__title"></h3>

                    <ul class="footer__social">
                        <a href="" target="_blank" class="footer__social-link">
                            <i class="ri-facebook-circle-fill"></i>
                        </a>

                        <a href="" target="_blank" class="footer__social-link">
                            <i class="ri-instagram-fill"></i>
                        </a>

                        <a href="" target="_blank" class="footer__social-link">
                            <i class="ri-twitter-x-line"></i>
                        </a>

                    </ul>
                </div>
            </div>
         </div>
        
      </footer>

      <!--========== SCROLL UP ==========-->
      <a href="#" class="scrollup" id="scroll-up">
        <i class="ri-arrow-up-line"></i>
      </a>

      <!--=============== SCROLLREVEAL ===============-->
      <script src=""></script>

      <!--=============== MAIN JS ===============-->
      <script src="./js/main.js"></script>
   </body>
</html>

<script>
  AOS.init();
</script>