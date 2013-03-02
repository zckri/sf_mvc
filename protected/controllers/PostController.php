<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PostController
 *
 * @author rooney
 */
class PostController extends JsonController{
    
        // Возвращает общее кол-во записей в модели Post
        public function actionOverall(){
            echo json_encode(array('count'=>Post::model()->getCount()));
        }
        
        // Возвращает посты с указанными параметрами
        public function actionIndex(){
            
            $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
               $num = isset($_GET['num']) ? $_GET['num'] : 10;
              $sort = isset($_GET['sort']) ? $_GET['sort'] : 'iddesc';
              $lang = isset($_GET['lang']) ? $_GET['lang'] : 'ru';
              $cat = isset($_GET['cat']) ? $_GET['cat'] : '0';
              $author = isset($_GET['author']) ? $_GET['author'] : '0';
            
            $model = Post::model()->getPosts($offset, $num, $sort, $lang,$cat,$author);
            
            $this->output($model);
        }
        
        
        // Возвращаем по Id запись
        public function actionGet(){
            if(!isset($_GET['id']))
                return false;
            
            $id = $_GET['id'];
            
            $lang = isset($_GET['lang']) ? $_GET['lang'] : 'ru';
            
            $model = Post::model()->getById($id,$lang);
            
            $this->output($model);
        }
}

?>
