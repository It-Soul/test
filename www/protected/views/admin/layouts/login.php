<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>


<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="shortcut icon" href="request->baseUrl; ?>/images/favicon.ico" type="image/x-icon"/>
    <?php Yii::app()->bootstrap->register(); ?>
    <link href="/css/style.css" media="screen" rel="stylesheet" type="text/css">
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div id="page">
    <div class="span3" style="width: 370px; height: 160px; margin: 35px">
        <a href="/admin/site">
            <img src="/images/logo.png" width="350"/>
        </a>
    </div>
    <?php echo $content; ?>

    <div class="row-fluid">
        <div class="footer span12">
            <div class="span5 offset1" style="margin-left: 10.5%">
                <div class="copyright">© 2015 - lc-parts.com</div>
                <div class="message">Передрукування і використання матеріалів в електронному форматі дозволяється тільки
                    за наявності гіперпосилання на lc-parts.com
                </div>
            </div>
            <div class="span5 mail"><b>E-mail: info.lcparts@gmail.com</b></div>
        </div>
    </div>
</div>
</body>
</html>

