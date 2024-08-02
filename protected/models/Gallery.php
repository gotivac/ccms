<?php

/**
 * This is the model class for table "gallery".
 *
 * The followings are the available columns in table 'gallery':
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $slug
 * @property integer gallery_image_id
 * @property string gallery_thumbnail
 * @property integer $active
 * @property integer $priority
 * @property string $created_dt
 * @property integer $created_user_id
 * @property string $updated_dt
 * @property integer $updated_user_id
 *
 * The followings are the available model relations:
 * @property GalleryImage[] $galleryImages
 */
class Gallery extends MultilingualActiveRecord
{

    public function primaryLang()
    {
        return 'sr_yu';
    }

    public function languages()
    {
        return Language::model()->langs;
    }

    public function localizedAttributes()
    {
        return array('title', 'slug', 'description');
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'gallery';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        $rules = array(
            array('title, slug', 'required'),
            array('active, priority, created_user_id, updated_user_id', 'numerical', 'integerOnly' => true),
            array('title, slug', 'length', 'max' => 255),
            array('created_dt, updated_dt,description', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title, description, slug, active, priority, created_dt, created_user_id, updated_dt, updated_user_id', 'safe', 'on' => 'search'),
        );
        foreach ($this->languages() as $l) {
            $rules[] = array('title_' . $l, 'length', 'max' => 256);
            $rules[] = array('slug_' . $l, 'safe');
            $rules[] = array('description_' . $l, 'safe');
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
            'galleryImages' => array(self::HAS_MANY, 'GalleryImage', 'gallery_id'),
            'createdUser' => array(self::BELONGS_TO,'User','created_user_id'),
            'updatedUser' => array(self::BELONGS_TO,'User','updated_user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        $labels = array(
            'id' => 'ID',
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'slug' => 'Slug',
            'active' => Yii::t('app', 'Active'),
            'priority' => Yii::t('app', 'Priority'),
            'created_dt' => Yii::t('app', 'Created'),
            'created_user_id' => Yii::t('app', 'Created by'),
            'updated_dt' => Yii::t('app', 'Updated'),
            'updated_user_id' => Yii::t('app', 'Updated by'),
        );
        foreach ($this->languages() as $l) {
            $labels['title_' . $l] = Yii::t('app', 'Title');
            $labels['slug_' . $l] = Yii::t('app', 'Slug');
            $labels['description_' . $l] = Yii::t('app', 'Description');


        }
        return $labels;
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('active', $this->active);
        $criteria->compare('priority', $this->priority);
        $criteria->compare('created_dt', $this->created_dt, true);
        $criteria->compare('created_user_id', $this->created_user_id);
        $criteria->compare('updated_dt', $this->updated_dt, true);
        $criteria->compare('updated_user_id', $this->updated_user_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Gallery the static model class
     */
    public static function model($className = __CLASS__)
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

    public function getImage()
    {
        for ($i = 0; $i <= 10; $i++) {
            $image = GalleryImage::model()->findByAttributes(array('gallery_id' => $this->id, 'priority' => $i));
            if ($image) {
                return $image;
            }
        }
        return new GalleryImage;
    }

}
