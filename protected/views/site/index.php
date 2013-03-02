<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<div class="wrappez">
<?php

$tmp = Category::model()->findAll();
$filter = CHtml::listData($tmp, 'id','runame');

$this->widget('bootstrap.widgets.TbGridView', array(

	'id'=>'post-grid',
	'type'=>'striped',
	'dataProvider' => $postModel->search(),
	'filter'=>$postModel,
	'responsiveTable' => true,
	'template' => "{items}{pager}",
	'columns' => array(
			'id',
			array(
					'type'=>'html',
					'name'=>'picpath_thumb',
					'value'=>'"<img src=\"".$data->picpath_thumb."\" />"',
			),
			'ru',
			array(
					'type'=>'raw',
					'name'=>'category_id',
					'value'=>'$data->category->runame',
					'filter'=>$filter,
				),
			array(
					'type'=>'raw',
					'name'=>'author_id',
					'value'=>'$data->author->name',
				),
			array(
					'header' => Yii::t('ses', 'Edit'),
					'class' => 'bootstrap.widgets.TbButtonColumn',
					'template' => '{update} {delete}',
					'buttons'=>array(
							'update'=>array(
									'label'=>'Редактировать',
									'url'=>'"/site/editPost/id/".$data->id',
								),
							'delete'=>array(
									'label'=>'Удалить',
									'url'=>'"/site/deletePost/id/".$data->id',
								),
						),
				),
		),
));
$this->widget('bootstrap.widgets.TbButton',array(
	'label' => 'Добавить объяву',
	'type' => 'primary',
	'size' => 'large',
	'url'=>'/site/newPost',
));
?>


</div>

