<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use db\book;

if (isset($_SESSION["logged_in"])) {
    if ($_SESSION["admin"] == "admin") {
        header("LOCATION: admindash.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../asset/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
</head>

<body>
    <input type="checkbox" id="check">
    <!--header area start-->
    <header>
        <label for="check">
            <i class="fas fa-bars" id="sidebar_btn"></i>
        </label>
        <div class="left_area">
            <h3>Bookhive</h3>
        </div>
    </header>
    <!--header area end-->
    <!--mobile navigation bar start-->
    <div class="mobile_nav">
        <div class="nav_bar">
            <i class="fa fa-bars nav_btn"></i>
        </div>
        <div class="mobile_nav_items">
            <a href="index.php"><i class="fas fa-home"></i><span>Home</span></a>
            <a href="#"><i class="fas fa-search"></i><span>Search Books</span></a>
            <a href="logout"><i class="fas fa-sign-out-alt"></i><span>Sign Out</span></a>
        </div>
    </div>
    <!--mobile navigation bar end-->
    <!--sidebar start-->
    <div class="sidebar">
        <div class="profile_info">
            <img src="../asset/images/OIP.jpg" class="profile_image" alt="">
            <h4><?php echo $_SESSION["uname"]?></h4>
        </div>
        <a href="index.php"><i class="fas fa-home"></i><span>Home</span></a>
        <a href="#"><i class="fas fa-search"></i><span>Search Books</span></a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i><span>Sign Out</span></a>
    </div>
    <!--sidebar end-->
    <script type="text/javascript">
        $(document).ready(function() {
            $('.nav_btn').click(function() {
                $('.mobile_nav_items').toggleClass('active');
            });
        });
    </script>
    <?php
    $k = new book;
    $row = $k->book_info($_SESSION["uno"]);
    ?>
</body>

</html>