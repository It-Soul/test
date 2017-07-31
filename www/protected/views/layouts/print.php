<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<?php
/* @var $this SiteController */
$app = Yii::app();
$this->pageTitle = Yii::app()->name;
?>
<head>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!--    <link rel="stylesheet" href="./css/jquery/jquery-ui-1.8.23.custom.css" type="text/css" media="screen">-->
    <!--        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>-->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css"/>
    <!--    <script type="text/javascript" src="/js/ui.datepicker-uk.js"></script>-->
    <link href="/css/normalize.css" media="screen" rel="stylesheet" type="text/css">
    <?php Yii::app()->bootstrap->register(); ?>
    <link href="/css/style.css" media="screen" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="request->baseUrl; ?>/images/favicon.ico" type="image/x-icon"/>
</head>
<body>
<?php echo $content; ?>
</body>
</html>

