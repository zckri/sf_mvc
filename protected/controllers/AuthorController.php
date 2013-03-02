<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AuthorController
 *
 * @author rooney
 */
class AuthorController extends JsonController{
    public function actionAll(){
        $this->output(Author::model()->getAll());
    }

    public function actionAllIntro(){
    	
    }
}

?>
