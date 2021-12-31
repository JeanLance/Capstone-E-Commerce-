<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Register Page">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="/assets/js/login_register1.js"></script>
    <link rel="stylesheet" href="/assets/css/login_register2.css">
    <link rel="stylesheet" href="/assets/css/main1.css">
    <title>Register Page | Dojo eCommerce</title>
</head>
<body>
    <div class="container"> 
        <h1>Dojo eCommerce</h1>
        <h2>Register</h2>
        <?= form_open('registerProcess')?>
            <label>First Name <span><span>*</span></span>
                <input id="first_name" type="text" name="first_name" value="<?= set_value('first_name') ?>">
                <?= form_error('first_name', '<div class="input-error-msg">', '</div>') ?>
            </label>
            <label>Last Name <span>*</span>
                <input id="last_name" type="text" name="last_name" value="<?= set_value('last_name') ?>">
                <?= form_error('last_name', '<div class="input-error-msg">', '</div>') ?>
            </label>
            <label>Email <span>*</span>
                <input id="email" type="email" name="email" value="<?= set_value('email') ?>">
                <?= form_error('email', '<div class="input-error-msg">', '</div>') ?>
            </label>
            <label>Contact No <span>*</span>
                <input id="contact_number" type="text" name="contact_number" value="<?= set_value('contact_number') ?>">
                <?= form_error('contact_number', '<div class="input-error-msg">', '</div>') ?>
            </label>
            <label>Password <span>*</span>
                <input id="password" type="password" name="password">
                <?= form_error('password', '<div class="input-error-msg">', '</div>') ?>
            </label>
            <label>Confirm Password <span>*</span>
                <input id="confirm_password" type="password" name="confirm_password">
                <?= form_error('confirm_password', '<div class="input-error-msg">', '</div>') ?>
            </label>
            <div><a href="<?= base_url()?>">Go to shop site</a><input type="submit" name="register" value="Register"></div>
        </form>
        <span class="form-change">Already have an account? <a href="<?= base_url()."login"?>">Login</a></span>
    </div>
</body>
</html>