<?php
/* @var $this OrdersController */
/* @var $model Orders */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'orders-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php if (Yii::app()->user->hasFlash('success')) { ?>
		<div class="row" style="width: 100%; margin-left: 0">
			<?php echo TbHtml::alert(TbHtml::ALERT_COLOR_SUCCESS, Yii::app()->user->getFlash('success')); ?>
		</div>
	<?php } ?>
	<?php if (Yii::app()->user->hasFlash('danger')) { ?>
		<div class="row" style="width: 100%; margin-left: 0">
			<?php echo TbHtml::alert(TbHtml::ALERT_COLOR_ERROR, $form->errorSummary($model)); ?>
		</div>
	<?php } ?>

	<table class="items table table-striped table-bordered">
		<tr>
			<td>
				Постачальник
			</td>
			<td>
				Назва
			</td>
			<td>
				Номер запчастини
			</td>
			<td>
				Виробник
			</td>
			<td>
				Кількість
			</td>
			<td>
				Ціна PLN
			</td>
			<td>
				Сума PLN
			</td>
			<td>
				Менеджер
			</td>
			<td>
				Куратор
			</td>
			<td>
				Адмін
			</td>
			<td>
				Ціна грн
			</td>
			<td>
				Сума грн
			</td>
			<td>
			</td>
		</tr>
		<tr>
			<td>
				<?php
				switch ($model->provider) {
					case    'http://webcatalog.opoltrans.com.pl/':
						echo 'Ополь';
						break;
					case    'http://sklep.martextruck.pl/':
						echo 'Мартекс';
						break;
					case    'http://www.intercars.com.pl/':
						echo 'Інтеркарс';
						break;
					case    'http://sklep.skuba.com.pl':
						echo 'Скуба';
						break;

				} ?>
			</td>
			<td style="width: 1500px">
				<?php echo $model->name ?>
			</td>
			<td>
				<?php echo $model->cod ?>
			</td>
			<td>
				<?php echo $model->manufacturer ?>
			</td>
			<td>
				<div class="row">
					<!--				--><?php //echo $form->labelEx($model, 'quantity'); ?>
					<?php echo $form->textField($model, 'quantity', array('style' => 'width:30px; margin-left: 35px')); ?>
					<?php echo $form->error($model, 'quantity'); ?>
				</div>
			</td>
			<td>
				<div class="row">
					<!--					--><?php //echo $form->labelEx($model,'price_in'); ?>
					<!--					--><?php //echo $form->labelEx($model,'price_in'); ?>
					<?php echo $form->textField($model, 'price_in', array('style' => 'width:70px; margin-left: 35px')); ?>
					<?php echo $form->error($model, 'price_in'); ?>
				</div>
			</td>
			<td>
				<div class="row">
					<!--					--><?php //echo $form->labelEx($model,'price_in_sum'); ?>
					<?php echo $form->textField($model, 'price_in_sum', array('style' => 'width:70px; margin-left: 35px')); ?>
					<?php echo $form->error($model, 'price_in_sum'); ?>
				</div>
			</td>
			<td>
				<div class="row">
					<!--					--><?php //echo $form->labelEx($model,'manager'); ?>
					<?php echo $form->textField($model, 'manager', array('style' => 'width:70px; margin-left: 35px')); ?>
					<?php echo $form->error($model, 'manager'); ?>
				</div>
			</td>
			<td>
				<div class="row">
					<!--					--><?php //echo $form->labelEx($model,'courier'); ?>
					<?php echo $form->textField($model, 'courier', array('style' => 'width:70px; margin-left: 35px')); ?>
					<?php echo $form->error($model, 'courier'); ?>
				</div>
			</td>
			<td>
				<div class="row">
					<!--					--><?php //echo $form->labelEx($model,'admin'); ?>
					<?php echo $form->textField($model, 'admin', array('style' => 'width:70px; margin-left: 35px')); ?>
					<?php echo $form->error($model, 'admin'); ?>
				</div>
			</td>
			<td>
				<div class="row">
					<!--					--><?php //echo $form->labelEx($model,'price_out'); ?>
					<?php echo $form->textField($model, 'price_out', array('style' => 'width:70px; margin-left: 35px')); ?>
					<?php echo $form->error($model, 'price_out'); ?>
				</div>
			</td>
			<td>
				<div class="row">
					<!--					--><?php //echo $form->labelEx($model,'price_out_sum'); ?>
					<?php echo $form->textField($model, 'price_out_sum', array('style' => 'width:70px; margin-left: 35px')); ?>
					<?php echo $form->error($model, 'price_out_sum'); ?>
				</div>
			</td>
			<td>
				<div class="row buttons">
					<?php
					echo CHtml::link(CHtml::encode('Зберегти'), array('admin/orders/update', 'id' => $model->id),
						array(
							'submit' => array('admin/orders/update', 'id' => $model->id, 'referrer' => Yii::app()->request->urlReferrer),
							'class' => 'btn btn-success',
							'style' => 'margin-left: 35px; margin-bottom: 10px'
						)
					); ?>
					<?php
					echo CHtml::link(CHtml::encode('Видалити'), array('admin/orders/delete', 'id' => $model->id),
						array(
							'submit' => array('admin/orders/delete', 'id' => $model->id, 'referrer' => Yii::app()->request->urlReferrer),
							'class' => 'btn btn-danger', 'confirm' => 'Видалити замовлення?',
							'style' => 'margin-left: 35px'
						)
					); ?>
				</div>
			</td>
		</tr>
	</table>


	<!--	<div class="row">-->
	<!--		--><?php //echo $form->labelEx($model,'ordered'); ?>
	<!--		--><?php //echo $form->dropDownList($model,'ordered',  array('0' => 'Ні', '1' => 'Так'))?>
	<!--		--><?php //echo $form->error($model,'ordered'); ?>
	<!--	</div>-->
	<!---->
	<!--	<div class="row">-->
	<!--		--><?php //echo $form->labelEx($model,'send'); ?>
	<!--		--><?php //echo $form->dropDownList($model,'send',  array('0' => 'Ні', '1' => 'Так'))?>
	<!--		--><?php //echo $form->error($model,'send'); ?>
	<!--	</div>-->
	<!---->
	<!--	<div class="row buttons">-->
	<!--		--><?php //echo CHtml::submitButton('Зберегти', array('class' => 'btn btn-success')); ?>
	<!--				--><?php //echo CHtml::link('Видалити', $this->createUrl('/admin/orders/delete', array('id' => $model->id)), array('class' => 'btn btn-danger', 'data-method' => 'POST')); ?>
	<!--		--><?php
	//		echo CHtml::link(CHtml::encode('Видалити'), array('admin/orders/delete', 'id'=>$model->id),
	//			array(
	//				'submit'=>array('admin/orders/delete', 'id'=>$model->id),
	//				'class' => 'btn btn-danger','confirm'=>'Видалити замовлення?'
	//			)
	//		);?>
	<!--	</div>-->

<?php $this->endWidget(); ?>

</div><!-- form -->