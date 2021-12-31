<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Header Partial">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <script src="/assets/js/custom_functions.js"></script>
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/header_partial.css">
    <title data-title-name="Header Partial (Temp)">Header Partial (Temp)</title>
</head>
<body>
    <div id="image-overlayer"></div>
    <img id="loading-buffer" src="/assets/img/loading-buffering.gif" alt="Loading Buffer">
<?php   if ($this->session->has_userdata('user_level') && $this->session->userdata('user_level') == 1) { ?>         <!-- Admin Session Navigation Bar -->
    <nav class="nav-admin">
        <ul>
            <li class="label"><a href="<?= base_url()?>dashboard">Dashboard</a></li>
            <li><a id="orders" href="<?= base_url()?>dashboard/orders">Orders</a></li>
            <li><a id="products" href="<?= base_url()?>dashboard/products">Products</a></li>
            <li class="side-action"><a href="<?= base_url()?>admin/logout">Logout</a></li>
        </ul>
    </nav>
<?php   } 
        else { ?>                                                                                                   <!-- Customer/Client Session Navigation Bar -->
    <nav class="nav-user">
        <ul>
            <li class="label"><a href="<?= base_url()?>products">Dojo eCommerce</a></li>
<?php   if (isset($_SESSION['user_level']) && $_SESSION['user_level'] == 0) { ?>
            <li class="side-action">
                <a href="#"><?= $_SESSION['user_fn'] . " " . $_SESSION['user_ln']?></a> <span>|</span>
                <a href="<?= base_url()?>carts">Shopping Cart (<span id="cart-item-count"><?= isset($_SESSION['cart_count']) ? $_SESSION['cart_count'] : "0";?></span>)</a> <span>|</span>
                <a href="<?= base_url()?>logout">Logout</a>
            </li>
<?php   } 
        else { ?>
            <li class="side-action"><a href="<?= base_url()."login"?>">Login</a> <span>|</span> <a href="<?= base_url()."register"?>">Register</a></li>
<?php   } ?>
        </ul>
    </nav>
<?php   } ?>