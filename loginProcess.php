<?php 
session_start(); //start or resume an existing session 
if(empty($_SESSION['loginInfo'])) {
   $_SESSION['loginInfo'] = array();
}


include 'inc/conn.php'; 

if (isset($_POST['loginForm'])) { //checks whether user submitted the form 
     
    $username = $_POST['username']; 
    $password = $_POST['password'];  //hash("sha1", $_POST['password']) 
     

             

    $sql = "SELECT *  
            FROM b_admin 
            WHERE username = :username 
            AND password = :password";  //Preventing SQL Injection 
             
    $namedParameters = array(); 
    $namedParameters[':username'] = $username;                 
    $namedParameters[':password'] = $password;             
     
    $statement = $conn->prepare($sql);  
    $statement->execute($namedParameters); 
    $record = $statement->fetch(PDO::FETCH_ASSOC); 
     
    if (empty($record)) { //wrong username or password 
         
        echo "Wrong username or password!"; 
         
    } else { 
         
		$_SESSION['access'] = $record['access_level']; 
		$_SESSION['userId'] = $record['id']; 
        $_SESSION['username'] = $record['username']; 
        $_SESSION['adminName'] = $record['first_name'] . " " . $record['last_name']; 
		$_SESSION['safezone'] = $record['organization_rep']; 
		$id = $_SESSION['userId'];
         
		if ($_SESSION['access'] == 0) {
			header("Location: admin.php"); 
        } else {
			header("Location: subAdmin.php"); 
		}
    }    
    
    echo "hello<br>".$_SESSION['access'];
} 
?>