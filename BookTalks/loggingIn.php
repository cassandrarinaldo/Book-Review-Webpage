<?php
function checkPassword($username, $userpassword){
    $db = new SQLite3 ("BookTalks.db" );    
    $sql = 'SELECT * FROM User WHERE username = :username';
    $stmt= $db -> prepare ($sql);
    $stmt -> bindParam (':username', $_POST['username'], SQLITE3_TEXT);
    $result= $stmt-> execute();
    $row = $result -> fetchArray ();
    $hashedpsw= $row['userpassword'];
        if(password_verify($_POST['password'], $hashedpsw)){
            $db->close();
            return true; 
        }
        else{
            $db->close();
            return false;}
}
function checkUser($username){
    $db = new SQLite3 ("BookTalks.db" );    
    $sql = 'SELECT username FROM User WHERE username = :username';
    $stmt= $db -> prepare ($sql);
    $stmt -> bindParam (':username', $_POST['username'], SQLITE3_TEXT);
    $result= $stmt-> execute();
    if ($row = $result -> fetchArray () ){
        $db->close();
        return true;
    }
    else{
        $db->close();
        return false; }   
}
function loginSuccess (){
    if (checkUser($_POST['username']) &&checkPassword($_POST['username'], $_POST['password'])){
        session_start();
		$_SESSION['activeuser']=$_POST['username'];
        $userID = getUserID();
        $_SESSION['userID'] = $userID;
        header("location: homePage.php");
    }
    elseif (!checkUser($_POST['username'])){
        session_start();
        $_SESSION['error']= "Incorrect username, please try again";
        header("location: logIn.php");
    } elseif (!checkPassword($_POST['username'], $_POST['password'])){
        session_start();
        $_SESSION['error']= "Incorrect password, pleasy try again";
        header("location: logIn.php");
    }
}
$usernameErr = $passwordErr = "";
$username = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"])) {
        $usernameErr = "A valid username is needed.";
    } else {
        $username = test_input($_POST["username"]);
        if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            $usernameErr = "Only letters and numbers are allowed.";
        }
    }
    if (empty($_POST["password"])) {
        $passwordErr = "A password is needed.";
    } else {
        $password = test_input($_POST["password"]);
        $checker = '/^(?=.*[a-zA-Z])(?=.*\d).{8,}$/';
        if (!filter_var($password, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => $checker)))) {
        $passwordErr = "The password must contain at least 1 number, 1 letter and contain at least 8 symbols.";
        }
    }
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($usernameErr) && empty($passwordErr)) {
    loginSuccess();
}
if (!empty($usernameErr)|| !empty($passwordErr)){
    echo $usernameErr; echo '<br>';
    echo $passwordErr;
}
else {
    echo "Unauthorized access of page detected. Please return to the start page.";
}
function getUserID(){
    $db = new SQLite3 ("BookTalks.db" );
	$sql = ("SELECT userID, username FROM User WHERE username = :username");
    $stmt = $db->prepare($sql);
    $stmt -> bindParam(':username', $_SESSION['activeuser'], SQLITE3_TEXT);
    $resultat = $stmt -> execute();
    while($row = $resultat->fetchArray()){
        $userID = $row['userID'];
    }
    $db->close();
    return $userID;
 }        
loginSuccess();
?>