<!DOCTYPE html>
<html lang="en">
<?php include "component/head.php"; ?>

<body>
    <?php include "component/navbar.php"; ?>

    <?php
    $page = isset($_GET['pages']) ? $_GET['pages'] : 'home';

    if ($page == 'home') {
        include "pages/home.php";
    } elseif ($page == 'team') {
        include "pages/team.php";
    } elseif ($page == 'recruitment') {
        include "pages/recruitment.php";
    } elseif ($page == 'contact') {
        include "pages/contactme.php";
    } else {
        include "pages/home.php";
    }
    ?>

    <?php include "component/footer.php"; ?>
    <?php include "component/bawahfuter.php"; ?>
</body>

</html>