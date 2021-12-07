<?php
    //Kích hoạt các biến ở dạng session
    session_start();

    $connect = new mysqli('localhost','root','','mobileshop');
    
    $member = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="Enter your description here"/>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>Mobile Shop</title>
</head>
<body>
    <section class="wrapper">
        <header>
            <?php include "view/layout/header.php"; ?>
        </header>
        <nav>
            <?php include"view/layout/menu-top.php"; ?>
        </nav>
        <section class="body">
            <aside>
                <?php include "view/layout/left.php"; ?>
            </aside>
            <!-- Body -->
            <article>
                <?php include "view/layout/article.php"; ?>
            </article>
            <aside>
                <?php include "view/layout/right.php"; ?>
            </aside>
        </section>
        <footer>
            <?php include "view/layout/footer.php"; ?>
        </footer>
    </section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
</body>
</html>