<?php
	$myServer = "localhost";
	$myUser = "admin";
	$myPass = "admin";
	$myDB = "MorPa";
	
	//connection to the database
	$dbhandler = mysql_connect($myServer, $myUser, $myPass)
	  or die("Couldn't connect to SQL Server on $myServer");
	if(!$dbhandler){echo "FAULT";}
	
	//select a database to work with
	$selected = mysql_select_db($myDB, $dbhandler)
	  or die("Couldn't open database $myDB");

    mysql_query("SET NAMES utf8");

    //ini_set("allow_url_include", true);
    require "kint/Kint.class.php";

    date_default_timezone_set("Europe/Kiev");
?>

<?php 
    sendEmail($_POST['user'], $_POST['email']);
?>

<?php
function sendEmail($user, $email){
    $mailBody = "<html>";
    $headers = "Content-Type: text/html; charset=UTF-8";
    
    $today = date('Y-m-d');
    
    $sql = "SELECT title, link FROM newsEntry, feed WHERE "
        //." date LIKE '$today%' AND "
        ."feed.id = newsEntry.feedID AND feed.user='$user' ORDER BY date ASC";
    $result = mysql_query($sql);
    
    while($row = mysql_fetch_assoc($result))
	{
        $mailBody .= "<li><a href='".$row["link"]."'>". $row["title"]."</a></li>";
	}
    
    
    $mailBody .= "</html>";
    mail($email, "Your news", $mailBody, $headers); 
}
?>