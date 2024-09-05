<?php
require_once 'essentials.php';
adminLogin();
session_regenerate_id(true);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Dashboard</title>
    <?php require('C:/xampp/htdocs/admin/inc/links.php'); ?>
    <style>
        #dashboard-menu {
            position: fixed;
            height: 100%;
        }

        @media screen and (max-width: 990px) {

            #dashboard-menu {
                height: auto;
                width: 100%;
            }

            #main-content {
                margin-top: 60px;
            }
        }
    </style>

</head>

<body class="bg-light">
    <?php require('C:/xampp/htdocs/admin/inc/header.php'); ?>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">SETTINGS</h3>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">General Settings</h5>
                            <button type="button" class="btn btn-dark shadow-none" data-bs-toggle="modal"
                                data-bs-target="#general-s"><i class="bi bi-pencil-square"></i>
                                Edit
                            </button>
                        </div>
                        <h6 class="card-subtitle mb-1 fw-bold">Site title</h6>
                        <p class="card-text">content</p>
                        <h6 class="card-subtitle mb-1 fw-bold">About us</h6>
                        <p class="card-text">content</p>
                    </div>
                </div>
                <div class="modal fade" id="general-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">General Settings</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Site title</label>
                                        <input type="text" name="site_title" class="form-control shadow-none">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">About us</label>
                                        <textarea name="site_about" class="form-control shadow-none" row="6"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn text-secondary shadow-none"
                                        data-bs-dismiss="modal">CANCEL</button>
                                    <button type="button" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <button>Gửi mail</button>
            </div>
        </div>

    </div>
    <?php require('C:/xampp/htdocs/admin/inc/scripts.php'); ?>

</body>

</html>