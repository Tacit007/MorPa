<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - About';
$this->breadcrumbs=array(
	'News',
);
?>

<?php if(Yii::app()->user->name == "Guest") {
    header("Location: index.php?r=site/login");
} ?>

<h1>News</h1>

<form method="post">
    <input type="text" name="email" value="<?php 
        echo Yii::app()->user->name;
    ?>" >
    <input type="submit">
</form>


<?php  if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['email']) {
    $mailBody = "<html>";
    $headers = "Content-Type: text/html; charset=UTF-8";
    
    $today = date('Y-m-d');
    
    $sql = "SELECT title, link FROM newsEntry, feed WHERE date LIKE '$today%' AND feed.id = newsEntry.feedID AND feed.user='".$_POST['email']."' ORDER BY date ASC";
    $result = mysql_query($sql);
    
    while($row = mysql_fetch_assoc($result))
	{
	  $mailBody .= "<li><a href='".$row["link"]."'>". $row["title"]."</a></li>";
	}
    
    
    $mailBody .= "</html>";
    mail($_POST['email'], "Your news", $mailBody, $headers); 
}
?>