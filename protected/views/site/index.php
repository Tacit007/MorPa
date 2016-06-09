<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<?php if(Yii::app()->user->name == "Guest") {
    header("Location: index.php?r=site/login");
} ?>

<?php if ($_SERVER['REQUEST_METHOD'] == "POST") { ?>
    <script>
        $.post(
            "_server/addFeed.php",
            {
                email: $('#email').val(),
                link: $('#link').val()
            },
            function(data){
                $("#result").html(data);
            }
        )
    </script>
?>

<div id="result"></div>

<form method="post">
    <input type="hidden" name="email" id="email" value="<?=Yii::app()->user->name?>">
    
    <input type="text" name="link" id="link" value="<?php 
        if ($_POST['link'])
            echo $_POST['link'];
        else
            echo "dou.ua";
    ?>" >
    <input type="submit">
</form>