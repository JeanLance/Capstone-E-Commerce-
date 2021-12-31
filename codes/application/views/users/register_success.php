<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Sucess!</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }
        html, body {
            height: 100%;
        }
        .container {
            width: 400px;
            min-height: 400px;
            border-radius: 5px;
            /* background-color: rgb(88, 155, 255); */
            background-image: linear-gradient(135deg, rgb(88, 155, 255) 40%, #fff);
            box-shadow: 0px 0px 8px #111;
            position: absolute;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -30%);
        }
            .container .success-check {
                width: 150px;
                height: 150px;
                border: 5px solid #008000;
                border-radius: 50%;
                position: absolute;
                top: 10%;
                left: 50%;
                transform: translate(-50%, -10%);
            }
                .success-check img {
                    width: 150px;
                    height: 150px;
                    border-radius: 50%;
                }
        .container .success-content {
            display: block;
            width: 100%;
            height: 50px;
            margin: 220px 0 0;
        }
            .success-content h1, .success-content h2, .success-content h4, .success-content p {
                text-align: center;
                margin: 5px 0;
            }
            .success-content h1 {
                color: #008000;
            }
            .success-content h2 {
                font-size: 22px;
                margin: 20px 0 15px;
            }
            .success-content p {
                text-decoration: underline;
                font-size: 20px;
            }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-check"><img src="/assets/img/success-check.png" alt="Success Image"></div>
        <span class="success-content">
            <h1>Success!</h1>
            <h4>You have successfully registered an account on Dojo eCommerce!</h4>
            <p><?= isset($email) ? $email : "email" ?></p>
            <h2>Redirecting to Login Form: <span id="seconds-left">5</span></h2>
        </span>
    </div>
</body>
<script>
    var countSeconds = 5;
    var countdown = setInterval(function() {
        countSeconds -= 1;
        if (countSeconds == 0) {
            console.log('is now: ' + countSeconds);
            clearInterval(countdown);
            window.location.href = "<?= base_url()?>login";
        }
        document.getElementById('seconds-left').innerHTML = countSeconds;
    }, 1000);
</script>
</html>