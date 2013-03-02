<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CategoryController
 *
 * @author rooney
 */
class CategoryController extends JsonController{
    
    // Вывести все категории
    public function actionAll(){
    	$lang = isset($_GET['lang']) ? $_GET['lang'] : 'ru';
    	if(!in_array($lang,array('ru','en','kz')))
    		$lang='ru';
        $this->output(Category::model()->getAll($lang));
    }
}

?>
