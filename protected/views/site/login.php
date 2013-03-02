<div class="formlog">
	<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	    'id'=>'verticalForm',
	    'htmlOptions'=>array('class'=>'well'),
	)); ?>
	 
	<span>Login:</span><br/>
	<input type="text" name="login" class="span3" /><br/>
	<span>Pass:</span><br/>
	<input type="password" name="password" class="span3" />
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Login')); ?>
	 
	<?php $this->endWidget(); ?>

	<div class="centor">
		<ul class="horiz">
		<?php foreach($str as $unit): ?>
			<li><img src="<?php echo $unit->url_thumb ?>" /></li>
		<?php endforeach?>
		</ul>
	</div>
</div>