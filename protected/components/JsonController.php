<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ZController
 *
 * @author rooney
 */
class JsonController extends CController{
    
    protected function beforeAction(){
        header('Content-type: application/json; charset=utf-8');
        return true;
    }
    
    protected function output($model){
        if(isset($_GET['raw']))
           print_r($model);
        else
            echo json_encode($model);
    }
    
}

?>
