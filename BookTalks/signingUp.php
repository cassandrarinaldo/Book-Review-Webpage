<?php
function addUser ($username, $email, $userpassword) {
	$count = 0;
    $db = new SQLite3 ("BookTalks.db" );
	$sql = "INSERT INTO User (username, user_email, userpassword) VALUES (:username, :email, :userpassword)";
	$stmt = $db -> prepare($sql);
	$stmt -> bindParam(':username', $username, SQLITE3_TEXT);
	$stmt -> bindParam (':email', $email, SQLITE3_TEXT);
	$stmt -> bindParam (':userpassword', $userpassword, SQLITE3_TEXT);
 	$result = $stmt -> execute ();
    while($row = $result->fetchArray())
        $count++;
    if($count=1){
        session_start();
        $_SESSION['activeuser'] = $username;
        $userID = getUserID();
        $_SESSION['userID'] = $userID;
        header('location: homePage.php');
    }
    else{
        session_start();
        $_SESSION['error'] = "Username already exists. Try another one.";
        header('location: signUp.php');
    }
 } 
 
 function checkEmail($email){
    $count=0;
    $db = new SQLite3 ("BookTalks.db" );
	$sql = "SELECT user_email FROM User WHERE user_email = :email";
	$stmt = $db -> prepare($sql);
	$stmt -> bindParam (':email', $email, SQLITE3_TEXT);
 	$result = $stmt -> execute ();
    while($row = $result->fetchArray())
        $count++;
    $db->close();
    if($count<1){
        return $email;
    }
    else{
        session_start();
        $_SESSION['error'] = "Email already exists. Try another one.";
        header('location: signUp.php');
    }
 }

 function checkUsername($username){
    $count=0;
    $db = new SQLite3 ("BookTalks.db" );
	$sql = "SELECT username FROM User WHERE username = :username";
	$stmt = $db -> prepare($sql);
	$stmt -> bindParam (':username', $username, SQLITE3_TEXT);
 	$result = $stmt -> execute ();
    while($row = $result->fetchArray())
        $count++;
    $db->close();
    if($count<1){
        return $username;
    }
    else{
        session_start();
        $_SESSION['error'] = "Username already exists. Try another one.";
        header('location: signUp.php');
    }
 }

$emailErr= $usernameErr = $passwordErr = "";
$email= $username = $userpassowrd = "";
    
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["email"])) {
		$emailErr = "An email is needed.";
	} else {
		$email = test_input($_POST["email"]);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailErr = "Not a valid format for an email.";
		}
	}
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
        $userpassword = test_input($_POST["password"]);
        $checker = '/^(?=.*[a-zA-Z])(?=.*\d).{8,}$/';
        if (!filter_var($userpassword, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => $checker)))) {
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($emailErr) && empty($usernameErr) && empty($passwordErr)) {
    addUser(checkUsername($_POST['username']), checkEmail($_POST['email']), password_hash($_POST['password'], PASSWORD_DEFAULT));
}
if (!empty($emailErr) || !empty($usernameErr)|| !empty($passwordErr)){
    echo $emailErr; echo '<br>';
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
?>