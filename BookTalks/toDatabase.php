<?php
    session_start();
function InsertData($userID, $reviewContent, $bookTitle){
    $db = new SQLite3('BookTalks.db');
    $statment = $db->prepare("INSERT INTO Review(userID, reviewContent, bookTitle) VALUES(:userID ,:reviewContent, :bookTitle)");
    $statment->bindValue(':reviewContent',$reviewContent,SQLITE3_TEXT);
    $statment->bindValue(':bookTitle',$bookTitle,SQLITE3_TEXT);
    $statment->bindValue(':userID',$userID,SQLITE3_INTEGER);
    $statment -> execute();
    $db->close();
}
function validate_notEmpty($data){
    if (strlen($data)>0) {
        return true;
    }
    else
        return false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(validate_notEmpty($_POST['reviewContent']) && validate_notEmpty($_POST['bookTitle'])) {
        InsertData($_SESSION['userID'],$_POST['reviewContent'],$_POST['bookTitle']);
        header('location: homePage.php');
    }	
    if(!validate_notEmpty($_POST['bookTitle']))
        echo "Invalid book title. Please return to the start page.<br>";
    if(!validate_notEmpty($_POST['reviewContent']))
        echo "Invalid review. Please return to the start page.<br>";
}
else {
    echo "Unauthorized access of page detected. Please return to the start page.";
}       
?>