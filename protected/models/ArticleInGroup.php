<?php

/**
 * This is the model class for table "article_in_group".
 *
 * The followings are the available columns in table 'article_in_group':
 * @property integer $id
 * @property integer $article_id
 * @property integer $article_group_id
 * @property integer $created_user_id
 * @property string $created_dt
 * @property integer $updated_user_id
 * @property string $updated_dt
 *
 * The followings are the available model relations:
 * @property Article $article
 * @property ArticleGroup $articleGroup
 */
class ArticleInGroup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'article_in_group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('article_id, article_group_id', 'required'),
			array('article_id, article_group_id, created_user_id, updated_user_id', 'numerical', 'integerOnly'=>true),
			array('created_dt, updated_dt', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, article_id, article_group_id, created_user_id, created_dt, updated_user_id, updated_dt', 'safe', 'on'=>'search'),
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
			'article' => array(self::BELONGS_TO, 'Article', 'article_id'),
			'articleGroup' => array(self::BELONGS_TO, 'ArticleGroup', 'article_group_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app','ID'),
			'article_id' => Yii::t('app','Article'),
			'article_group_id' => Yii::t('app','Article Group'),
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
		$criteria->compare('article_id',$this->article_id);
		$criteria->compare('article_group_id',$this->article_group_id);
		$criteria->compare('created_user_id',$this->created_user_id);
		$criteria->compare('created_dt',$this->created_dt,true);
		$criteria->compare('updated_user_id',$this->updated_user_id);
		$criteria->compare('updated_dt',$this->updated_dt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ArticleInGroup the static model class
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
		return parent::beforeSave();
	}
	
	
	public function afterSave()
    {

        if (isset(Yii::app()->user)) {
            Yii::app()->Helpers->saveLog($this);
        }
        
        return parent::afterSave();
    }
	
	public function beforeDelete()
        {
		if (isset(Yii::app()->user)) 
		{
		    $copy = $this;
		    $copy->scenario = 'delete';
		    Yii::app()->Helpers->saveLog($copy);
		}
		return parent::beforeDelete();
        }
}
