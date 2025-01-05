<?php
session_start();
if(!isset($_SESSION['activeuser'])){
    header('Location: startpage.php');
}?>

<!DOCTYPE html>
<html>
<head>
    <title>BookTalks</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css">
</head>

</html>
<body class="homePage">
    <script>
        function validateForm(){
            let reviewContent = document.reviewForm.reviewContent.value.trim();
            let bookTitle = document.reviewForm.bookTitle.value.trim();
        
            if (reviewContent.length>0 && bookTitle.length>0){
                return true;
            }

            let error = "";
            if (reviewContent.length<1){
                error += "Please enter a review\n";
            }
            if (bookTitle.length<1){
                error += "Please enter a book title\n";
            }
            alert(error);
            return false;
        }
    </script>
    <div class="header">
        <h1>BookTalks</h1>
        <p> <?php echo ("Welcome ". $_SESSION['activeuser'] ."!")?></p>
    </div>
    <div class="row">
        <h3>Write a review!</h3>
        <?php
            $userID = $_SESSION['userID'];
            echo '<form name="reviewForm" id="reviewForm" action="toDatabase.php" method="POST" onsubmit="return validateForm()">';
            echo '<label for="bookTitle">Book title:</label>';
            echo '<input type="text" name="bookTitle" id="bookTitle" placeholder="Ex. The Hobbit...">';
            echo '<label for="reviewContent">Review:</label>';
            echo '<textarea id="reviewContent" name="reviewContent" placeholder="Write your review here"></textarea>';
            echo "<input type='hidden' name='userID' id='userID' value='$userID'>";
            echo '<input type="submit" class="submitbtn" value="Post review">';
        ?>
    </div>
    <div class="row1">
        <h3>Reviews</h3>
        <br>
        <hr>
        <?php
            function getPost(){
                $db = new SQLite3('BookTalks.db'); 
                $resultat = $db->query("SELECT r.userID, r.reviewContent, r.bookTitle, u.username FROM Review r 
                INNER JOIN User u ON u.userID = r.userID ORDER BY reviewId DESC");
                while($row = $resultat->fetchArray())
                {
                    ?>
                    <div class="columnlft">
                        <div id="username"><?php
                            echo $row['username'];?>
                        </div>
                        <div id="bookTitledisplay"><?php
                            echo $row['bookTitle'];?>
                        </div>
                     </div>
                    <div class="columnrt">
                        <div id="reviewContent"><?php
                            echo $row['reviewContent'];?>
                        </div>
                    </div> <hr> <?php
                }
                $db->close();
            }
            getPost();
        ?>
    </div>
    <div class="footer">
        <a class="logoutbtn" href="loggingOut.php">Log out</a>
    </div>
</body>
</html>