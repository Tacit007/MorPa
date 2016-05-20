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
?>

<?php  /*
    public static function feedToNews($feedURL){
    
        $content = file_get_contents($feedURL);
        $x = new SimpleXmlElement($content);

        foreach($x->channel->item as $entry) {
            $list[] = $entry;
        }

        foreach($list as $entry) {
            $aLink = $entry->link;
            $aTitle = substr($entry->title, 0, 500);
            $aDate = DateTime::createFromFormat(DateTime::RSS, $entry->pubDate)->format("Y-m-d H:i:s");

            $sql = "INSERT INTO newsEntry (link, title, date) VALUES ( '$aLink', '$aTitle', '$aDate');";

            //echo $sql."<br><br>";
            Yii::app()->db->createCommand($sql)->execute();
        
        $sql = "
            DELETE newsEntry 
            FROM newsEntry
            LEFT OUTER JOIN (
               SELECT MIN(id) as id, title
               FROM newsEntry 
               GROUP BY title
            ) as KeepRows ON
               newsEntry.id = KeepRows.id
            WHERE
               KeepRows.id IS NULL
        ";
        //echo $sql;
        mysql_query($sql);
        //$command = Yii::app()->db->createCommand($sql)->execute();
        }
    }
    
    public static function feedToList($feedURL){
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

    public static function sendEmail(){
        $headers = "Content-Type: text/html; charset=UTF-8";

        $mailBody = "<html>";

        $today = date('Y-m-d');
        $sql = "SELECT title, link FROM newsEntry WHERE date LIKE '$today%' ORDER BY date ASC";
        $result = mysql_query($sql);

        while($row = mysql_fetch_assoc($result))
        {
          $mailBody .= "<li><a href='".$row["link"]."'>". $row["title"]."</a></li>";
        }
        $mailBody .= "</html>";

        mail($_POST['email'], "Your news", $mailBody, $headers);    
    }

    public static function feedToDB(){
        if (substr($_POST['link'], 0, 4) != "www." && substr($_POST['link'], 0, 4) != "http" ) 
            $_POST['link'] = "www.".$_POST['link'];

        $ch = curl_init();

        // установка URL и других необходимых параметров
        curl_setopt($ch, CURLOPT_URL, "http://ajax.googleapis.com/ajax/services/feed/lookup?v=1.0&q=".$_POST['link']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $responseJSON = curl_exec($ch);

        $response = json_decode ($responseJSON);

        if ($response->responseDetails != "no associated feed") {
            $feedURL = $response->responseData->url;

            $sql = "
                INSERT INTO feed (feed.feedURL) VALUES ('$feedURL');
            ";
            $command = Yii::app()->db->createCommand($sql)->execute();

            // Удаляем повторения
            $sql = "
                DELETE feed 
                FROM feed
                LEFT OUTER JOIN (
                   SELECT MIN(id) as id, feedURL
                   FROM feed 
                   GROUP BY feedURL
                ) as KeepRows ON
                   feed.id = KeepRows.id
                WHERE
                   KeepRows.id IS NULL
            ";
            $command = Yii::app()->db->createCommand($sql)->execute();

            echo 'Added! '.$feedURL.'<br><br><br>';
        } else {
            echo "<h2>Ссылка не может быть использована</h2>";
        }
    
        feedToNews($feedURL);
    
        feedToList($feedURL);
    }
*/?>



<?php
    include("http://localhost/tools/Kint/Kint.class.php");
    Kint::dump($_POST);
//if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['email'] "" && $_POST['link']) {
//}
?>



