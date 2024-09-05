<?php
require_once 'db_config.php';
require_once 'essentials.php';
adminLogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Painel Tầng lầu</title>
    <?php require('C:/xampp/htdocs/admin/inc/links.php'); ?>
</head>

<body>
    <?php require('C:/xampp/htdocs/admin/inc/header.php'); ?>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Tầng lầu</h3>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <button type="button" class="btn btn-dark shadow-none" data-bs-toggle="modal"
                                data-bs-target="#add_tanglau"><i class="bi bi-plus-square"></i>
                                ADD
                            </button>

                        </div>
                        <div class="table-responsive-lg" style="height: 450px overflow-y: scroll;">
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Mã tầng</th>
                                        <th scope="col">Tên tầng</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="room-data">
                                    <?php
                                    $query = "SELECT * FROM `tanglau` ORDER BY `MATANGLAU` DESC";
                                    $data = mysqli_query($con, $query);
                                    $i = 1;

                                    while ($row = mysqli_fetch_assoc($data)) {
                                        echo <<<query
                                        <tr>
                                            <td>$i</td>
                                            <td>$row[MATANGLAU]</td>
                                            <td>$row[TENTANGLAU]</td>
                                            <td>
                                                <button type='button' onclick='edit_khachhang($row[MATANGLAU])' class='btn btn-primary shadow-none' data-bs-toggle='modal'
                                                data-bs-target='#edit_khachhang'><i class='bi bi-pencil-square'></i>
                                                </button>

                                                <button type='button' onclick='delete_khachhang($row[MATANGLAU])' class='btn btn-danger' data-bs-toggle='modal'
                                                data-bs-target='#edit_khachhang'><i class='bi bi-trash'></i>
                                                </button>
                                            </td>
                                        </tr>
                                        query;
                                        $i++;
                                    }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="add_tanglau" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="add_tanglau_form" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Thêm tầng lầu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Mã tầng</label>
                                <input type="text" name="MATANGLAU" class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tên tầng</label>
                                <input type="text" name="TENTANGLAU" class="form-control shadow-none">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none"
                            data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-outline-success">SUBMIT</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <?php require('C:/xampp/htdocs/admin/inc/scripts.php'); ?>

    <script>
        let add_tanglau_form = document.getElementById('add_tanglau_form');
        add_tanglau_form.addEventListener('submit', function (e) {
            e.preventDefault();
            add_tanglau();

        });
        function add_tanglau() {
            let data = new FormData();
            data.append('add_tanglau', '');
            data.append('MATANGLAU', add_tanglau_form.elements['MATANGLAU'].value);
            data.append('TENTANGLAU', add_tanglau_form.elements['TENTANGLAU'].value);

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "tanglaus.php", true);

            $kq = xhr.onload = function () {
                var myModal = document.getElementById('add_tanglau');
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();
                if ($kq == 0) {
                    alert('Success', 'Thêm loại phòng thành công !');
                    add_khachhang_form.reset();
                }
                else {
                    alert('Lỗi-Erorr', 'Server Down!');
                }
            }
            xhr.send(data);

        }
    </script>
</body>