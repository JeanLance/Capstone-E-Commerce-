<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login Page">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="/assets/js/login_register1.js"></script>
    <link rel="stylesheet" href="/assets/css/login_register2.css">
    <link rel="stylesheet" href="/assets/css/main1.css">
    <title>Login Page | Dojo eCommerce</title>
</head>
<body>
    <div class="container"> 
        <h1>Dojo eCommerce</h1>
        <h2>Login</h2>
        <?= form_open('loginProcess')?>
            <label>Email <span>*</span>
                <input id="email" type="email" name="email" value="<?= set_value('email')?><?= isset($email) ? $email : ""?>">
                <?= form_error('email', '<div class="input-error-msg">', '</div>') ?>
                <?= isset($user_not_found) ? '<div class="input-error-msg">'. $user_not_found .'</div>' : ""?>
                <?= isset($unauthorize) ? '<div class="input-error-msg">'. $unauthorize .'</div>' : ""?>
            </label>
            <label>Password <span>*</span>
                <input type="password" name="password">
                <?= form_error('password', '<div class="input-error-msg">', '</div>') ?>
                <?= isset($password_incorrect) ? '<div class="input-error-msg">'. $password_incorrect .'</div>' : ""?>
            </label>
            <div><a href="<?= base_url()?>">Go to shop site</a><input type="submit" name="login" value="Login"></div>
        </form>
        <span class="form-change">Don't have an account yet? <a href="<?= base_url()."register"?>">Register</a> now!</span>
    </div>
</body>
</html>