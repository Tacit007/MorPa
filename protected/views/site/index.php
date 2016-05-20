<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<?php if ($_SERVER['REQUEST_METHOD'] == "POST") {    
    if (substr($_POST['link'], 0, 4) != "www." && substr($_POST['link'], 0, 4) != "http" ) 
        $_POST['link'] = "www.".$_POST['link'];
    //echo $_POST['link'];
    
    //Kint::dump($_POST['link']);
    
    $ch = curl_init();

    // установка URL и других необходимых параметров
    curl_setopt($ch, CURLOPT_URL, "http://ajax.googleapis.com/ajax/services/feed/lookup?v=1.0&q=".$_POST['link']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    $responseJSON = curl_exec($ch);
    
    $response = json_decode ($responseJSON);
    
    //Kint::dump($response);
    
    if ($response->responseDetails != "no associated feed") {
        $feedURL = $response->responseData->url;

        $sql = "
            INSERT INTO feed (feed.feedURL) VALUES ('$feedURL');
        ";
        $command = Yii::app()->db->createCommand($sql)->execute();
        
        ///////////////////////////////////////////
        
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
        //echo $sql;
        $command = Yii::app()->db->createCommand($sql)->execute();
        
        echo 'Added! '.$feedURL.'<br><br><br>';
    } else echo "<h2>Ссылка не может быть использована</h2>";
    
    
    
    //////////////////////////////////////////////////////////////////////////////
    
    
    
    NewsEntry::feedToNews($feedURL);
    
    //echo $sqlAll;
    
    
    /*echo "<ul>";
    foreach($list as $entry) {
        echo "<li><a href='$entry->link' title='$entry->title'>" . $entry->title . "</a></li>";
    }
    echo "</ul>";*/
    
    //unset($list);


    NewsEntry::feedToList($feedURL);
/*$content = file_get_contents($feedURL);
$x = new SimpleXmlElement($content);
//Kint::dump($x->channel);
foreach($x->channel->item as $entry) {
    $list[] = $entry;
}

echo "<ul>";
foreach($list as $entry) {
    echo "<li><a href='$entry->link' title='$entry->title'>" . $entry->title . "</a></li>";
}
echo "</ul>";*/
    
}

?>

<form method="post">
    <input id="big" type="text" name="link" value="<?php 
        if ($_POST['link'])
            echo $_POST['link'];
        else
            echo "dou.ua";
    ?>" >
    <input id="big" type="submit">
</form>