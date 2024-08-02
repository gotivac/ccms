<?php

/**
 * This is the model class for table "gallery_image".
 *
 * The followings are the available columns in table 'gallery_image':
 * @property integer $id
 * @property integer $gallery_id
 * @property string $filename
 * @property string $filepath
 * @property string $thumbname
 * @property string $thumbpath
 * @property integer $priority
 * @property string $created_dt
 * @property integer $created_user_id
 * @property string $updated_dt
 * @property integer $updated_user_id
 *
 * The followings are the available model relations:
 * @property Gallery $gallery
 */
class GalleryImage extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'gallery_image';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gallery_id, filename, filepath', 'required'),
			array('gallery_id, priority, created_user_id, updated_user_id', 'numerical', 'integerOnly'=>true),
			array('filename, filepath, thumbname, thumbpath', 'length', 'max'=>255),
			array('created_dt, updated_dt', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, gallery_id, filename, filepath, thumbname, thumbpath, priority, created_dt, created_user_id, updated_dt, updated_user_id', 'safe', 'on'=>'search'),
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
			'gallery' => array(self::BELONGS_TO, 'Gallery', 'gallery_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app','ID'),
			'gallery_id' => Yii::t('app','Gallery'),
			'filename' => Yii::t('app','Filename'),
			'filepath' => Yii::t('app','Filepath'),
			'thumbname' => Yii::t('app','Thumbname'),
			'thumbpath' => Yii::t('app','Thumbpath'),
			'priority' => Yii::t('app','Priority'),
			'created_dt' => Yii::t('app','Created Dt'),
			'created_user_id' => Yii::t('app','Created User'),
			'updated_dt' => Yii::t('app','Updated Dt'),
			'updated_user_id' => Yii::t('app','Updated User'),
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
		$criteria->compare('gallery_id',$this->gallery_id);
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('filepath',$this->filepath,true);
		$criteria->compare('thumbname',$this->thumbname,true);
		$criteria->compare('thumbpath',$this->thumbpath,true);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('created_dt',$this->created_dt,true);
		$criteria->compare('created_user_id',$this->created_user_id);
		$criteria->compare('updated_dt',$this->updated_dt,true);
		$criteria->compare('updated_user_id',$this->updated_user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GalleryImage the static model class
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
}
