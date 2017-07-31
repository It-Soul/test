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
<div class="container" id="page">

    <div class="row">
        <div class="span4" style="width: 370px; height: 160px; margin: 35px">
            <a href="/site/index">
                <img src="/images/logo.png"/>
            </a>
        </div>
    </div>
    <?php echo $content; ?>
    <div class="row-fluid">
        <div class="navbar navbar-default">
            <div class="footer">
                <div class="span5 offset1" style="margin-left: 10.5%">
                    <div class="copyright">© 2015 - lc-parts.com</div>
                    <div class="message">Передрукування і використання матеріалів в електронному форматі дозволяється
                        тільки за наявності гіперпосилання на lc-parts.com
                    </div>
                </div>
                <div class="span5 mail"><b>E-mail: info.lcparts@gmail.com</b></div>
                <div>
                    <strong>
                        <span>
                            <span lang="EN-GB" style="font-family: Arial; color: #1155cc; mso-ansi-language: EN-GB;"><span style="white-space: pre-wrap;">
                                    <span style="color: #000000; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: normal; white-space: normal;">&nbsp;</span>
                                </span>
                            </span>
                        </span>
                    </strong>
                </div><!-- footer -->
        </div>

    </div>
</div><!-- page -->

</body>
</html>

