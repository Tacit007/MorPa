<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - About';
$this->breadcrumbs=array(
	'News',
);
?>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.3.min.js"></script>

<?php if(Yii::app()->user->name == "Guest") {
    header("Location: index.php?r=site/login");
} ?>

<h1>News</h1>

<?php if ($_SERVER['REQUEST_METHOD'] == "POST") { ?> <script>
    $.post('_server/sendEmail.php', { user: '<?=$_POST['user']?>', email: '<?=$_POST['email']?>' }).done(function(data) {
        $("#result").html(data);
    });
</script><?php } ?>

<form method="post">
    <input type="hidden" name="user" value="<?php 
        echo Yii::app()->user->name;
    ?>">
    <input type="text" name="email" value="<?php 
        if ($_POST['email'])
            echo $_POST['email'];
        else
            echo Yii::app()->user->name;
    ?>">
    <input type="submit">
</form>