<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<?php if ($_SERVER['REQUEST_METHOD'] == "POST") { ?>
    <script>
        $.post(
            "_server/index.php",
            {
                email: $('#email').val(),
                link: $('#link').val()
            },
            function(data){
                $("#result").html(data);
            }
        )
    </script>
<?php } ?>

<form method="post">
    <input id="email" type="text" name="email" value="<?php 
        if ($_POST['email'])
            echo $_POST['email'];
        else
            echo "tacit.gugl@gmail.com";
    ?>" >
    
    <input id="link" type="text" name="link" value="<?php 
        if ($_POST['link'])
            echo $_POST['link'];
        else
            echo "dou.ua";
    ?>" >
    
    <input type="submit">
</form>

<div id="result"></div>