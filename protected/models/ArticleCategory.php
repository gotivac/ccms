<?php

/**
 * This is the model class for table "article_category".
 *
 * The followings are the available columns in table 'article_category':
 * @property integer $id
 * @property string $parent_id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property integer $created_user_id
 * @property string $created_dt
 * @property integer $updated_user_id
 * @property string $updated_dt
 *
 * The followings are the available model relations:
 * @property ArticleCategoryLang[] $articleCategoryLangs
 */
class ArticleCategory extends MultilingualActiveRecord
{

    public function primaryLang() {
        return 'sr_yu';
    }

    public function languages() {
        return Language::model()->langs;
    }

    public function localizedAttributes() {
        return array('title','description','slug');
    }


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'article_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		$rules =  array(
			array('title', 'required'),
			array('created_user_id, updated_user_id', 'numerical', 'integerOnly'=>true),
			array('parent_id', 'length', 'max'=>45),
			array('title, slug', 'length', 'max'=>255),
			array('description, created_dt, updated_dt', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent_id, title, slug, description, created_user_id, created_dt, updated_user_id, updated_dt', 'safe', 'on'=>'search'),
		);
        foreach ($this->languages() as $l) {
            $rules[] = array('title_'.$l, 'length', 'max'=>256);
            $rules[] = array('slug_'.$l, 'safe');
            $rules[] = array('description_'.$l, 'safe');
        }
        return $rules;
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'articleCategoryLangs' => array(self::HAS_MANY, 'ArticleCategoryLang', 'article_category_id'),
            'parent' => array(self::BELONGS_TO,'ArticleCategory','parent_id'),

            'createdUser' => array(self::BELONGS_TO,'User','created_user_id'),
            'updatedUser' => array(self::BELONGS_TO,'User','updated_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app','ID'),
			'parent_id' => Yii::t('app','Parent'),
			'title' => Yii::t('app','Title'),
			'slug' => Yii::t('app','Slug'),
			'description' => Yii::t('app','Description'),
			'created_user_id' => Yii::t('app','Created User'),
			'created_dt' => Yii::t('app','Created Dt'),
			'updated_user_id' => Yii::t('app','Updated User'),
			'updated_dt' => Yii::t('app','Updated Dt'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('parent_id',$this->parent_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('created_user_id',$this->created_user_id);
		$criteria->compare('created_dt',$this->created_dt,true);
		$criteria->compare('updated_user_id',$this->updated_user_id);
		$criteria->compare('updated_dt',$this->updated_dt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => 100,
            ),

		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ArticleCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->created_user_id = Yii::app()->user->id;
            $this->created_dt = date('Y-m-d H:i:s');
        } else {
            $this->updated_user_id = Yii::app()->user->id;
            $this->updated_dt = date('Y-m-d H:i:s');
        }

        $slug = $this->slug;
        $duplicate = $this->findByAttributes(array("slug" => $slug));
        if ($duplicate && $duplicate->id != $this->id && $duplicate->slug != null) {

            $cnt = 1;
            do {
                $tmp_slug = $slug . "-" . $cnt;
                $cnt++;
            } while ($this->findByAttributes(array("slug" => $tmp_slug)));
            $this->slug = $tmp_slug;
        } else {
            $this->slug = $slug;
        }

        return parent::beforeSave();
    }
}
