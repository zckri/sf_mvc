<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<!--<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	-->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
<!--	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />-->

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<?php

function check($arg){
	return strstr($_SERVER['REQUEST_URI'],$arg) ? true : false;
}

if(!Yii::app()->user->isGuest){

$this->widget('bootstrap.widgets.TbNavbar', array(
	'brand' => 'Yermo',
	'items' => array(
		array(
			'class' => 'bootstrap.widgets.TbMenu',
			'items' => array(
				array('label'=>'Объявы', 'url'=>'/site', 'active'=>strcmp($_SERVER['REQUEST_URI'],'/site')==0),
				array('label'=>'Категории', 'url'=>'/site/categoryx', 'active'=>check('/site/categoryx')),
				array('label'=>'Авторы', 'url'=>'/site/authorx','active'=>check('/site/authorx')),
				array('label'=>'Выход', 'url'=>'/site/logout'),
			)
		)
	)
));

}
?>
<!--<div style="width:100%; height:100%; display:block;background: url(http://fc09.deviantart.net/fs71/i/2012/167/1/c/catrinel_menghia_sexy_by_magxlander-d53on5w.png) no-repeat">-->
<div class="container">

	<?php echo $content; ?>
</div>

</div><!-- page -->

<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>

</body>
</html>
