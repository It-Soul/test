<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<html>
<body>
<div class="row-fluid page-wrap">
    <div class="span12">
        <div class="span1"></div>
        <div class="span10">
            <div class="span12">
                <!-- Login form -->
                <div class="span6">
                    <h1>Адмінпанель</h1>

                    <p>Заповніть наступні поля:</p>

                    <div class="form">
                        <?php $form=$this->beginWidget('CActiveForm', array(
                            'id'=>'login-form',
                            'enableClientValidation'=>true,
                            'clientOptions'=>array(
                                'validateOnSubmit'=>true,
                            ),
                        )); ?>
                        <p class="note">Поля зі значком <span class="required">*</span> обов’язкові.</p>
                        <div class="row">
                            <?php echo $form->labelEx($model,'email'); ?>
                            <?php echo $form->textField($model,'email'); ?>
                            <?php echo $form->error($model,'email'); ?>
                        </div>

                        <div class="row">
                            <?php echo $form->labelEx($model,'password'); ?>
                            <?php echo $form->passwordField($model,'password'); ?>
                            <?php echo $form->error($model,'password'); ?>
                            <!--		<p class="hint">-->
                            <!--			Hint: You may login with <kbd>demo</kbd>/<kbd>demo</kbd> or <kbd>admin</kbd>/<kbd>admin</kbd>.-->
                            <!--		</p>-->
                        </div>

                        <div class="row rememberMe">
                            <?php echo $form->checkBox($model,'rememberMe'); ?>
                            <?php echo $form->label($model,'rememberMe'); ?>
                            <?php echo $form->error($model,'rememberMe'); ?>
                        </div>
                        <br>
                        <div class="row buttons">
                            <?php echo CHtml::submitButton('Вхід'); ?>
<!--                            --><?php //echo CHtml::link('Реєстрація',array('site/registration')); ?>
                            </br>
<!--                            --><?php //echo CHtml::link('Забули пароль?',(array('site/recovery',array(
//                                'font-size'=>'10em',
//                            )))); ?><!--<br>-->
                        </div>
                        <?php $this->endWidget(); ?>
                    </div><!-- form -->
                    <br>
                </div>
                <!-- EOF Login form -->
                <!-- Cart section-->
                <div class="span6 cart-section">
                </div>
                <!-- End of Cart Section -->
            </div>
        </div>
    </div>
</div>
</body>
</html>