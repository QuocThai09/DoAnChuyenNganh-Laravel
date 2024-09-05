
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300;700&family=Poppins:wght@200;400&display=swap"
    rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

    <link rel="stylesheet" type="text/css" href="css/common.css">
    <style>
        div.login-form {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
        }
        body{
            background-image: url('images/background.jpg');
        }
        
    </style>
</head>
    <body class="bg-light">
        <div class="login-form text-center rounded bg-white shadow overflow-hidden" style="opacity:0.7">
            <form method="POST" action="">
                <h4 class="bg-dark text-white py-3">ADMIN LOGIN</h4>
                @if($message = Session::get('error'))
                    <div class="alert alert-error alert-block">
                        <button style="button" class="close" data-dismiss="alert"></button>
                        <strong>{{$message}}</strong>
                    </div>
                @endif
                @csrf
                <div class="p-4" style="opacity:1">
                    <div class="mb-3">
                        <input name="name" required type="text" class="form-control shadow-none text-center"
                            placeholder="Admin Name">
                    </div>
                    <div class="mb-4">
                        <input name="password" required type="password" class="form-control shadow-none text-center"
                            placeholder="Password">
                    </div>
                    <button name="login" type="submit"  class="btn text-black custom-bg shadow-none">LOGIN</button>
                </div>
            </form>
        </div>
    </body>

    </html>
