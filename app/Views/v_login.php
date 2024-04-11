<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Domine:wght@400;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/fontawesome-free/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <title>MSI | Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Domine:wght@400;600;800&display=swap');
        
        * {
            font-family: 'Domine', sans-serif;
        }
        
        body {
            background-image: url("1.jpg");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }
        
        .box {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 90vh;
        }
        
        .container {
            width: 350px;
            display: flex;
            flex-direction: column;
            padding: 0 15px 0 15px;
        
        }
        
        span {
            color: #fff;
            margin-top: 20px;;
            font-size: 18px;
            font-weight: bold;
            display: flex;
            justify-content: center;
            padding: 10px 0 10px 0;
        }
        
        header {
            color: yellow;
            font-size: 24px;
            display: flex;
            justify-content: center;
            padding: 10px 0 10px 0;
            margin-bottom: 20px;
            font-weight: 400;
        }
        
        .input-field .input {
            height: 45px;
            width: 87%;
            border: none;
            border-radius: 30px;
            color: #fff;
            font-size: 16px;
            padding: 0 0 0 45px;
            background: rgba(255, 255, 255, 0.1);
            outline: none;
        }

        .logo {
            display: flex;
            justify-content: center;

        }
        
        i {
            position: relative;
            top: -33px;
            left: 17px;
            color: #fff;
        }
        
        ::-webkit-input-placeholder {
            color: #fff;
        }
        
        .submit {
            margin-top: 20px;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            height: 45px;
            outline: none;
            width: 100%;
            color: black;
            background: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            transition: .3s;
        }
        
        .submit:hover {
            box-shadow: 1px 5px 7px 1px rgba(0, 0, 0, 0.5);
        }
        
        .two-col {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            color: #fff;
            font-size: small;
            margin-top: 10px;
        }
        
        .one {
            display: flex;
        }
        
        label a {
            text-decoration: none;
            color: #fff;
        }        
    </style>

</head>

<body>
    <div class="box">
        <div class="container">
            <?php echo form_open('auth/cek_login') ?>
            <div class="top">
                <img src="<?= base_url() ?>/login/img/logomsi.png" class="logo" style="width: 180px;height: 80px;margin-left: 80px;border-radius:0%;">
                <span style="color:yellow"><b>PT. MULTI SCREEN INDONESIA</b></span>
            </div>
            <div class="input-field" style="margin-top: 30px">
                <input type="text" class="input" placeholder="Username" id="username" name="username" autocomplete="off">
                <i class='bx bx-user'></i>
            </div>
            <div class="input-field">
                <input type="Password" class="input" placeholder="Password" id="password" name="password">
                <i class='bx bx-lock-alt'></i>
            </div>
            <div class="input-field">
                <input type="submit" class="submit" value="Login" id="login">
            </div>
            <?php form_close() ?>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#username').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#password').focus();
            }
            $('#password').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#login').focus();
            }
        });
        
        });

    </script>
    <!--<script type="text/javascript" src="login/js/main.js"></script>-->
</body>

</html>