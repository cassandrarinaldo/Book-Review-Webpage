<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sign up</title>
    <meta charset="utf-8">
    <script type = "text/javascript" src="validate.js"></script>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <h3>Sign up</h3>
    <?php 
    if (isset($_SESSION['error'])){
       ?> <p> <?php echo $_SESSION['error'];?> </p> 
        <?php 
        session_unset(); 
        session_destroy();
    }?>
    <form name="signup" method="post" action="signingUp.php" onsubmit="return test()">
        <label for="username"><b>Enter a username</b></label>
        <input type="text" placeholder="This will be your username" name="username" required>
        <label for="email"><b>Enter your email</b></label>
        <input type ="text" placeholder="example@examplemail.se" name ="email" required>
        <label for="password"><b>Enter a password</b></label>
        <input type="password" placeholder="Must be at least 8 characters, one uppercase, one lowercase and one number." name="password" required>
        <input type="submit" value="Sign up" class="submitbtn"> <br>
        <button onclick="document.location='startPage.php'" class="cancelbtn" >Cancel</button> <br>
    </form>
</body>
</html>