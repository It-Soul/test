<div class="row span12">
<?php
/* @var $this CabinetController */

$this->breadcrumbs=array(
	'Мій кабінет',
);
?>

<div class="row span2">
<?php $this->renderPartial('_cabinetmenu'); ?>
</div>

<div class="span4">
	<?php
	if(Yii::app()->user->hasFlash('index')): ?>
    </br>
    <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_SUCCESS, Yii::app()->user->getFlash('index')); ?>
    <?php else: ?>
    <?php endif; ?>

	<?php
	if(Yii::app()->user->hasFlash('error')): ?>
	</br>
	<?php echo TbHtml::alert(TbHtml::ALERT_COLOR_DANGER, Yii::app()->user->getFlash('error')); ?>
	<?php else: ?>
    <?php endif; ?>


		<div   class="form" align="center">
			<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'users-form',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
					'validateOnSubmit'=>true,
				),
			)); ?>
			<?php echo $form->errorSummary($model); ?>


			<div class="row">
				<?php echo $form->labelEx($model,'organisation'); ?>
				<?php echo $form->textField($model,'organisation'); ?>
				<?php echo $form->error($model,'organisation'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'organisation_status'); ?>
				<?php echo $form->dropDownList($model,'organisation_status',array('ПП' => 'ПП', 'ТОВ' => 'ТОВ', 'ДП' => 'ДП','ТДВ'=>'ТДВ','ТзОВ'=>'ТзОВ','ФОП'=>'ФОП'))?>
				<?php echo $form->error($model,'organisation_status'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'username'); ?>
				<?php echo $form->textField($model,'username'); ?>
				<?php echo $form->error($model,'username'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'phone'); ?>
				<?php echo $form->textField($model,'phone'); ?><br>
				<?php echo CHtml::button('Надіслати код', array('class' => 'btn btn-warning phone_code_btn', 'id' => 'sendConfirmCode', 'disabled' => true))?>
				<?php echo $form->error($model,'phone'); ?>
				<div id="confirmDiv">
					<br/><input type="tel" placeholder="Введіть код із смс" id="confirmCode">
					<button type="button" class="btn btn-success" id="checkConfirmCode">Перевірити код</button>
				</div>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'email'); ?>
				<?php echo $form->textField($model,'email'); ?>
				<?php echo $form->error($model,'email'); ?>
			</div>

			<div class="row" id="country">
				<?php echo $form->labelEx($model,'country'); ?>
				<?php echo $form->dropDownList($model,'country',  $countries, array('prompt' => ''))?>
				<?php echo $form->error($model,'country'); ?>
			</div>
			<div class="row" id="region" >
				<?php echo $form->labelEx($model,'region'); ?>
				<?php echo $form->dropDownList($model,'region',  $regions, array('prompt' => ''))?>
				<?php echo $form->error($model,'region'); ?>
			</div>

			<div class="row" id="city" >
				<?php echo $form->labelEx($model,'city'); ?>
				<?php echo $form->dropDownList($model,'city',  $cities, array('prompt' => ''))?>
				<?php echo $form->error($model,'city'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'reg_like'); ?>
				<?php echo $form->dropDownList($model,'reg_like',  array('Магазин' => 'Магазин', 'Сервіс' => 'Сервіс', 'Перевізник' => 'Перевізник / власник ТЗ'), array('prompt'=>''))?>
				<?php echo $form->error($model,'reg_like'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'carrier'); ?>
				<?php echo $form->dropDownList($model,'carrier',  array('Нова Пошта' => 'Нова Пошта', 'Гюнсел' => 'Гюнсел', 'Автолюкс' => 'Автолюкс', 'Інтайм' => 'Інтайм', 'Делівері' => 'Делівері'), array('prompt'=>''))?>
				<?php echo $form->error($model,'carrier'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'district'); ?>
				<?php echo $form->textField($model,'district'); ?>
				<?php echo $form->error($model,'district'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'old_password'); ?>
				<?php echo $form->passwordField($model,'old_password'); ?>
				<?php echo $form->error($model,'old_password'); ?>


			</div>
			<div class="row">
				<?php echo $form->labelEx($model,'new_password'); ?>
				<?php echo $form->passwordField($model,'new_password'); ?>
				<?php echo $form->error($model,'new_password'); ?>
			</div>




			<div class="row buttons">
				<?php echo CHtml::submitButton('Зберегти зміни', array('class' => 'btn btn-success', 'id' => 'register')); ?>
			</div>

			<?php $this->endWidget(); ?>
		</div><!-- form -->

	</div>

</div>
</div>
<script type="text/javascript" src="/js/maskedinput.js"></script>
<script>
	$("#Users_country").change(function(){
		var country = $("#Users_country option:selected").val();
		$.ajax({
			type: "POST",
			url: "/site/region",
			data: {
				country_id: country
			},
			success: function(json){
				var data = JSON.parse(json);
				$("#Users_region").empty();
				$("#Users_region").append($("<option></option>", {
					value: '',
					text: ''
				}));
				$("#region").fadeIn(200);
				for( var dataVal in data){
					$("#Users_region").append($("<option></option>", {
						value: dataVal,
						text: data[dataVal]
					}));
				};
			}
		});
	});

	$("#Users_region").change(function(){
		var region = $("#Users_region option:selected").val();
		$.ajax({
			type: "POST",
			url: "/site/city",
			data: {
				region_id: region
			},
			success: function(json){
				var data = JSON.parse(json);
				$("#Users_city").empty();
				$("#Users_city").append($("<option></option>", {
					value: '',
					text: ''
				}));
				$("#city").fadeIn(200);
				for( var dataVal in data){
					$("#Users_city").append($("<option></option>", {
						value: dataVal,
						text: data[dataVal]
					}));
				};
			}
		});
	});
	$("#Users_phone").mask('+38(999) 999 99 99');
	$("#Users_phone").change(function(){
		if($(this).val() != ''){
			$("#sendConfirmCode").attr('disabled', false);
		} else {
			$("#sendConfirmCode").attr('disabled', true);
		}
	});
	$("#sendConfirmCode").click(function(){
		$.ajax({
			type : "POST",
			url : '/site/confirm',
			data : {
				phone : $("#Users_phone").val()
			},
			success : function(json){
				var confirm_result = JSON.parse(json);
//                alert(confirm_result['code']);
				if(confirm_result['status']==1){
					$("#confirmDiv").fadeIn();
					$("#register").attr('disabled', true);
				}
			}
		});
	});
	$("#checkConfirmCode").click(function(){
		$.ajax({
			type : "POST",
			url : '/site/check',
			data : {
				code : $("#confirmCode").val()
			},
			success : function(json){
				var data = JSON.parse(json);
				if(data['status']==1){
					$("#register").attr('disabled', false);
				} else {
					$("#register").attr('disabled', true);
				}
			}
		})
	})
</script>
