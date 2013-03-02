<?php

class SiteController extends Controller
{        

	public function init(){
		header('Content-Type: text/html; charset=utf-8');
	}

	protected function beforeAction(){
		if(Yii::app()->user->isGuest)
			$this->actionLogin();
		
		return true;
	}

	public function actionIndex()
	{
		$model = new Post('search');
		
		$model->unsetAttributes();
		if(isset($_GET['Post'])){
			$model->attributes = $_GET['Post'];

		}
		if(isset($_GET['ajax'])) {
	        $this->renderPartial('index',array(
	            'postModel'=>$model,
	        ));
	        
		}else{
			$this->render('index',array('postModel'=>$model));
		}
	}


	public function actionCategoryx(){
		$model = new Category('search');
		$model->unsetAttributes();
		if(isset($_GET['Category'])){
			$model->attributes = $_GET['Category'];

		}
		if(isset($_GET['ajax'])) {

	        $this->renderPartial('categoryx',array(
	            'categoryModel'=>$model,
	        ));
		}else{
			$this->render('categoryx',array('categoryModel'=>$model));
		}
	}

	public function actionAuthorx(){
		$model = new Author('search');
		$model->unsetAttributes();
		if(isset($_GET['Author'])){
			$model->attributes = $_GET['Author'];

		}
		if(isset($_GET['ajax'])) {

	        $this->renderPartial('authorx',array(
	            'authorModel'=>$model,
	        ));
		}else{
			$this->render('authorx',array('authorModel'=>$model));
		}
	}

	public function actionNewPost(){
		$model = new Post();
		$authors = Author::model()->getTiny();
		$categories = Category::model()->getAll();

		$this->pageTitle = 'Создание новой объявы';

		if(isset($_POST['Post'])){
			
			$model->attributes = $_POST['Post'];
			if(!empty($_FILES['file']['tmp_name'])){
				$fname = time().mt_rand(10,100).'.jpg';
				$fpath = getcwd().'/upload/';

				move_uploaded_file($_FILES['file']['tmp_name'], $fpath.$fname);
				//echo $fpath.$fname;
				$img = new SimpleImage($fpath.$fname);
				$img->square_crop(150)->save($fpath.'thumb_'.$fname);
				
				$model->picpath = '/upload/'.$fname;
				$model->picpath_thumb = '/upload/thumb_'.$fname;
			
			
				if(!$model->save()){
					unlink($fpath.$fname);
					unlink($fpath.'thumb_'.$fname);
					$error = $model->getErrors();
					$this->render('newpost',array('model'=>$model, 
										  	'authors'=>$authors,
										  	'categories'=>$categories,'error'=>$error));
					die();
				}else{
					$this->redirect('/site');
				}
			}
			else
				$this->render('newpost',array('model'=>$model, 
											  	'authors'=>$authors,
											  	'categories'=>$categories,'error'=>array(array('Заполните все поля'))));
		}

		$this->render('newpost',array('model'=>$model, 
									  'authors'=>$authors,
									  'categories'=>$categories));
	}

	public function actionEditPost(){

	}

	public function actionDeletePost($id){
		$model = Post::model()->findByPk($id);
		if(!isset($model))
			die();
		@unlink(getcwd().$model->picpath);
		@unlink(getcwd().$model->picpath_thumb);
		$model->delete();
		$this->redirect('/site');
	}

	public function actionLogout(){
		Yii::app()->user->logout();
		$this->redirect('/site/login');
	}

	public function actionLogin(){
		$str = file_get_contents('http://laststand.in/post/index/num/5');
    	
		if(isset($_POST['login'])){
			$username = $_POST['login'];
			if(!isset($_POST['password']))
				die();
			$password = $_POST['password'];
			$identity=new UserIdentity($username,$password);
			if($identity->authenticate()){
			    Yii::app()->user->login($identity);
			    $this->redirect('/site/index');
			}
			else
			    echo $identity->errorMessage;
		}
		$this->render('login',array('str'=>json_decode($str)));
		die();
	}
}