<?php

/**
 * This is the model class for table "post".
 *
 * The followings are the available columns in table 'post':
 * @property integer $id
 * @property string $picpath
 * @property string $picpath_thumb
 * @property integer $category_id
 * @property integer $author_id
 * @property string $ru
 * @property string $en
 * @property string $kz
 * @property integer $created
 * @property integer $updated
 * @property integer $visits
 * @property integer $rating
 */
class Post extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Post the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'post';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('picpath, category_id, author_id', 'required'),
			array('category_id, author_id, created, updated, visits, rating', 'numerical', 'integerOnly'=>true),
			array('picpath', 'length', 'max'=>255),
			array('ru, en, kz', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, picpath, category_id, author_id, ru, en, kz, created, updated, visits, rating, picpath_thumb', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'author'=>array(self::BELONGS_TO, 'Author', 'author_id'),
                    'category'=>array(self::BELONGS_TO, 'Category', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'picpath' => 'Пикча',
			'category_id' => 'Категория',
			'author_id' => 'Автор',
			'ru' => 'Описание',
			'en' => 'Description',
			'kz' => 'ХЗ',
			'created' => 'Создано',
			'updated' => 'Обновлено',
			'visits' => 'Визиты',
			'rating' => 'Рейтинг',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('picpath',$this->picpath,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('author_id',$this->author_id);
		$criteria->compare('ru',$this->ru,true);
		$criteria->compare('en',$this->en,true);
		$criteria->compare('kz',$this->kz,true);
		$criteria->compare('created',$this->created);
		$criteria->compare('updated',$this->updated);
		$criteria->compare('visits',$this->visits);
		$criteria->compare('rating',$this->rating);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
           
        private $sort_dict = array(
                'tdesc'=>'post.created DESC',
                'tasc'=>'post.created ASC',
                'vdesc'=>'post.visits DESC',
                'vasc'=>'post.visits ASC',
                'rdesc'=>'post.rating DESC',
                'rasc'=>'post.rating ASC',
                'iddesc'=>'post.id DESC',
                'idasc'=>'post.id ASC',
            );
        
        private $lang_dict = array(
            'ru'=>'post.ru',
            'en'=>'post.en',
            'kz'=>'post.kz',
        );
        
        // самая юзаемая Тимой ф-ция. Вытаскивает всё в виде массива из БД
        public function getPosts($offset=0,      // отступ от начала
                                 $num=10,        // кол-во записей
                                 $sort='iddesc',  // сортировка = tdesc/tasc/vasc/vdesc/rasc/rdesk
                                 $lang='ru',     // язык = ru/en/kz
                                 $cat='0',
                                 $author='0'){ // фильтрация = author/category
            
            
            // отвалидируем говно извне
            if(!array_key_exists($sort, $this->sort_dict))
                    $sort = 'iddesc';
            if(!array_key_exists($lang, $this->lang_dict))
                    $lang = 'ru';
            
            // отвалидируем макс/мин значения лимита
            $max = $this->getCount();
            
            if($num<=0) $num=10;
            if($num>$max) $num=$max;
            
            if($offset<0 || $max-$offset<=0)
                $offset=0;
            
            // ну и собсна жирный запрос (жадный)
            $criteria = new CDbCriteria();
            
            $criteria->alias = 'post';
            //$criteria->with = array('author'=>array('select'=>'id, name, contact'),
            //                        'category'=>array('select'=>"id, {$lang}name"));
         
            $criteria->limit = $num;
            $criteria->offset = $offset;
            $criteria->select = 'post.id, post.picpath, post.picpath_thumb, category_id, author_id, '.$this->lang_dict[$lang];
            $criteria->order = $this->sort_dict[$sort];
            
            if($cat!='0')
                $criteria->addColumnCondition(array('category_id'=>$cat));
            
            if($author!='0')
                $criteria->addColumnCondition(array('author_id'=>$author));
            
            $posts = Post::model()->findAll($criteria);
            
            // превратим это дело (модель) в массив
            return $this->postsToArray($posts,$lang);
        }
        
        // Одиночная вытаскивалка
        public function getById($id, $lang='ru'){
            if(!isset($id))
                return false;
            
            if(!array_key_exists($lang, $this->lang_dict))
                    $lang = 'ru';
            
            $criteria = new CDbCriteria();
            
            $criteria->alias = 'post';
            $criteria->with = array('author'=>array('select'=>'id, name, contact'),
                                    'category'=>array('select'=>"id, {$lang}name"));
         
            $criteria->select = 'post.id, post.picpath, post.picpath_thumb '.$this->lang_dict[$lang];
            $criteria->addColumnCondition(array('post.id'=>$id));
            
            $post = Post::model()->find($criteria);
            if(!($post instanceOf Post))
                return false;
            // превратим это дело (модель) в массив
            return $this->postToArray($post,$lang);

        }
        
        
        // ОДИН ПОСТ К МАССИВУ
        private function postToArray($post, $lang){
            $host = Yii::app()->request->getServerName();
                $url = $post->picpath;
              
            $result = array(
                'id'=>$post->id,
                'url'=> 'http://'.$host.$post->picpath,
                'url_thumb'=>'http://'.$host.$post->picpath_thumb,
                'content'=>$post->attributes[$lang],
                'author'=>array(
                    'id'=>$post->author->id,
                    'name'=>$post->author->name,
                    'contact'=>$post->author->contact,
                ),
                'category'=>array(
                    'id'=>$post->category->id,
                    "name"=>$post->category->attributes[$lang.'name'],
                ),
                
            );
            return $result;
        }
        
        // МНОГО ПОСТОВ К МАССИВУ 
        private function postsToArray($posts,$lang){
            $result = array();
            $i=0;
            $host = Yii::app()->request->getServerName();
            foreach($posts as $post){
                $result[$i] = array_filter($post->attributes);
                
                // поправим URL
                $url = $result[$i]['picpath'];
                $result[$i]['url'] = 'http://'.$host.$url;
                $result[$i]['url_thumb'] = 'http://'.$host.$result[$i]['picpath_thumb'];
                unset($result[$i]['picpath']);
                unset($result[$i]['picpath_thumb']);


                // поправим LANG
                $result[$i]['content'] = $result[$i][$lang];
                unset($result[$i][$lang]);
                
                // свяжем с автором
                // $result[$i]['author'] = array(
                //     'id'=>$post->author->id,
                //     'name'=>$post->author->name,
                //     'contact'=>$post->author->contact,
                // );
                
                // // свяжем с категорией
                // $result[$i]['category'] = array(
                //     'id'=>$post->category->id,
                //     "name"=>$post->category->attributes[$lang.'name'],
                // );
                $i++;
            }
            return $result;
        }
        
        // ОБЩЕЕ КОЛ-ВО ЭЛЕМЕНТОВ В ТАБЛИЦЕ POST
        public function getCount(){
            $sql = 'SELECT COUNT(id) FROM post';
            return Yii::app()->db->cache(3200)->createCommand($sql)->queryScalar();
        }
}