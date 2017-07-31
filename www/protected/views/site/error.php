<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<?php if ($code == 404) { ?>
	<h2>Error <?php echo $code; ?></h2>

	<div class="error">
		<?php echo CHtml::encode($message); ?>
	</div>
<?php } else { ?>
	<h2>Error 500</h2>

	<div class="error">
		Щось пішло не так.
        <?php echo CHtml::encode($message); ?>
	</div>
<?php } ?>
