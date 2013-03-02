<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<div class="wrappez">
<?php

$this->widget('bootstrap.widgets.TbGridView', array(

	'id'=>'post-grid',
	'type'=>'striped',
	'dataProvider' => $authorModel->search(),
	'filter'=>$authorModel,
	'responsiveTable' => true,
	'template' => "{items}{pager}",
	'columns' => array(
			'id',
			'name','contact','extra',
			array(
					'header' => Yii::t('ses', 'Edit'),
					'class' => 'bootstrap.widgets.TbButtonColumn',
					'template' => '{update} {delete}',
				),
		),
));
?>
</div>
