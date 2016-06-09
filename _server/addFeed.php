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
    addNewFeed($_POST['link'], $_POST['email']);
?>

<?php

function checkFeed($feedURL){
    $content = file_get_contents($feedURL);
    $x = new SimpleXmlElement($content);
    if($x->channel->item[0]->pubDate && checkFeedExistanse($feedURL))
        return true;
    else return false;
}

function checkFeedExistanse($feedURL) {
    $feedURL = mysql_real_escape_string($feedURL);
    
    $sql = "SELECT feedURL FROM feed WHERE feedURL='".$feedURL."'";
    $result = mysql_query($sql);
    
    if (!mysql_fetch_assoc($result))
        return true;
    else return false;
}

function feedToNews($feedURL){
        $content = file_get_contents($feedURL);
        $x = new SimpleXmlElement($content);

        foreach($x->channel->item as $entry) {
            $list[] = $entry;
        }
        
        foreach($list as $entry) {
            $aLink = $entry->link;
            $aTitle = substr($entry->title, 0, 500);
            $aDate = DateTime::createFromFormat(DateTime::RSS, $entry->pubDate)->format("Y-m-d H:i:s");
            $feedID = mysql_fetch_assoc(mysql_query(
                "SELECT id FROM feed WHERE feedURL='".$feedURL."';"
            )); $feedID = $feedID['id'];
            
            $sql = "INSERT INTO newsEntry (link, title, date, feedID) VALUES ( '$aLink', '$aTitle', '$aDate', '$feedID');";
            mysql_query($sql);
        }
    }

function feedToList($feedURL){
    $content = file_get_contents($feedURL);
    $x = new SimpleXmlElement($content);
    foreach($x->channel->item as $entry) {
        $list[] = $entry;
    }

    echo "<ul>";
    foreach($list as $entry) {
        echo "<li><a href='$entry->link' title='$entry->title'>" . $entry->title . "</a></li>";
    }
    echo "</ul>";
}

function addNewFeed($link, $email){
    if (substr($link, 0, 4) != "www." && substr($link, 0, 4) != "http" )  {
        $link = "www.".$link;
    }
        
    // установка URL и других необходимых параметров
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://ajax.googleapis.com/ajax/services/feed/lookup?v=1.0&q=".$link);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    $responseJSON = curl_exec($ch);
    $response = json_decode ($responseJSON);
    
    if ($response->responseDetails != "no associated feed" && $response->responseDetails != "invalid url" && checkFeed($response->responseData->url)) {
       $feedURL = $response->responseData->url;

        $sql = "INSERT INTO feed (feed.feedURL, feed.user) VALUES ('$feedURL', '$email');";
        mysql_query($sql);
    
        echo 'Лента "'.$feedURL.'" добавлена!'.'<br><br><br>';
        
        feedToNews($feedURL);
        feedToList($feedURL);
    }
    elseif(checkFeedExistanse($feedURL)) echo "<h2>Сайт уже добавлен</h2>";
    else echo "<h2>Ссылка не может быть использована</h2>";
}

?>