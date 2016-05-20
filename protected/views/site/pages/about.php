<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - About';
$this->breadcrumbs=array(
	'News',
);
?>
<h1>News</h1>

<form method="post">
    <input id="12345" type="text" name="email" value="<?php 
        if ($_POST['email'])
            echo $_POST['email'];
        else
            echo "tacit.gugl@gmail.com";
    ?>" >
    <input type="submit">
</form>


<script>
    $.post(
        "_server/index.php",
            {
                email: $('#12345').val()
            },
            function(data){
                
            }
    )
</script>