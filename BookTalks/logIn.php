<?php
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Log in</title>
    <meta charset="utf-8">
    <script type = "text/javascript" src="validation.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h3>Log in</h3>
    <p>Please insert your username and password. Log in to post a review!</p>
    <br>
    <?php
        if(isset($_SESSION['error'])){
            ?> <p> <?php echo $_SESSION['error'];?> </p> 
            <?php 
            session_unset();
            session_destroy();
        }
    ?>
    <form name="login" method="post" id="loginForm" action="loggingIn.php" onsubmit="return test()">
        <label for="username">Username:</label>
        <input type="text" placeholder="Enter username:" name="username" required>
        <label for="password">Password:</label>
        <input type="password" placeholder="Enter password:" name="password" required>
        <input type="submit" value="Log in" class=" submitbtn">
        <button onclick="document.location='startPage.php'" class="cancelbtn" >Cancel</button> <br>
    </form>
</body>
</html>