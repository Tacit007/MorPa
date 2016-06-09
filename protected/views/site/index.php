<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<?php if(Yii::app()->user->name == "Guest") {
    header("Location: index.php?r=site/login");
} ?>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.3.min.js"></script>

<?php if ($_SERVER['REQUEST_METHOD'] == "POST") { ?> <script>
    $.post('_server/addFeed.php', { email: '<?=$_POST['email']?>', link: '<?=$_POST['link']?>' }).done(function(data) {
        $("#result").html(data);
    });
</script><?php } ?>

<div id="result"></div>

<form method="POST">
    <input type="hidden" name="email" value="<?=Yii::app()->user->name?>">
    
    <input type="text" name="link" value="<?php 
        if ($_POST['link'])
            echo $_POST['link'];
        else
            echo "dou.ua";
    ?>" >
    <input type="submit">
</form>