
<div class="span12">
    <div class="span6">
        <h1>Вхід</h1>
        <p>Заповніть наступні поля:</p>
        <div class="form">
            <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'login-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
            )); ?>
            <p class="note">Поля зі значком <span class="required">*</span> обов’язкові.</p>
            <div class="row">
                <?php echo $form->labelEx($model, 'email'); ?>
                <?php echo $form->textField($model, 'email'); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>
            <div class="row">
                <?php echo $form->labelEx($model, 'password'); ?>
                <?php echo $form->passwordField($model, 'password'); ?>
                <?php echo $form->error($model, 'password'); ?>
                <!--		<p class="hint">-->
                <!--			Hint: You may login with <kbd>demo</kbd>/<kbd>demo</kbd> or <kbd>admin</kbd>/<kbd>admin</kbd>.-->
                <!--		</p>-->
            </div>
            <div class="row rememberMe">
                <?php echo $form->checkBox($model, 'rememberMe'); ?>
                <?php echo $form->label($model, 'rememberMe'); ?>
                <?php echo $form->error($model, 'rememberMe'); ?>
            </div>
            <br>
            <div class="row buttons">
                <?php echo CHtml::submitButton('Вхід'); ?>
                <?php echo CHtml::link('Реєстрація', array('site/registration')); ?>
                </br>
                <?php echo CHtml::link('Забули пароль?', (array('site/recovery'))); ?><br>
            </div>

            <?php $this->endWidget(); ?>
        </div><!-- form -->
        <br>
    </div>
</div>
<div class="span10 about">
    <h4 style="text-align: center;"><span style="font-family: Verdana;"><strong>Сайт копанії "Logistics Parts" відображає наявність складів найбільших Європейських операторів ринку </strong></span>
    </h4>
    <h4 style="text-align: center;"><span style="font-family: Verdana;"><strong>TIR Запчастин.</strong></span></h4>
    <h4>&nbsp;</h4>
    <h4 style="text-align: center;"><span style="font-family: Verdana;"><strong>Сайт максимально інтегрований для Українського ринку. Ціни наведені в гривнях з урахуванням доставки запчастин в Україну в найкоротші терміни.</strong></span>
    </h4>
    <p>&nbsp;</p>
    <p class="MsoNormal" style="text-align: center;" align="center">&nbsp;</p>
    <div style="text-align: left;"><code><strong>ціни доступні після регістрації</strong></code></div>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <div><strong><span lang="EN-GB"
                       style="font-size: 14pt; font-family: blzee; color: teal; background-position: initial initial; background-repeat: initial initial;">Logistics Parts</span></strong>
    </div>
    <div class="MsoNormal"><strong><span lang="EN-GB"
                                         style="font-size: 10pt; font-family: Arial;">E-mail: </span></strong><strong><span
                style="font-size: 10.0pt;"><span lang="EN-GB"
                                                 style="font-family: Arial; color: #1155cc; mso-ansi-language: EN-GB;"><span
                        style="white-space: pre-wrap;"><a
                            href="mailto:info.lcparts@gmail.com">info.lcparts@gmail.com</a></span></span></span></strong>
    </div>

</div>