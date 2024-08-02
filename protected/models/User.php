<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * 
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $password

 * @property string $roles
 * @property string $notes
 * @property string $session_start
 * @property integer $code
 * @property integer $active
 * @property integer $created_user_id
 * @property string $created_dt
 * @property integer $updated_user_id
 * @property string $updated_dt
 */
class User extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, email, password, roles', 'required'),
            array('email', 'unique'),
            array('code,  active, created_user_id, updated_user_id', 'numerical', 'integerOnly' => true),
            array('name, email, password, roles,  phone, ', 'length', 'max' => 255),
            array('session_start, notes, created_dt, updated_dt', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, email, password, roles, notes, session_start, code, active, phone, created_user_id, created_dt, updated_user_id, updated_dt', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
           
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
           
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'roles' => Yii::t('app', 'Role'),
            'notes' => Yii::t('app', 'Notes'),
            'session_start' => Yii::t('app', 'Session Start'),
            'code' => Yii::t('app', 'Code'),

            'phone' => Yii::t('app','Phone'),
            'active' => Yii::t('app', 'Active'),
            'created_user_id' => Yii::t('app', 'Created User'),
            'created_dt' => Yii::t('app', 'Created Dt'),
            'updated_user_id' => Yii::t('app', 'Updated User'),
            'updated_dt' => Yii::t('app', 'Updated Dt'),
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
       
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('roles', $this->roles, true);
        $criteria->compare('notes', $this->notes, true);
        $criteria->compare('session_start', $this->session_start, true);
        $criteria->compare('code', $this->code);
        $criteria->compare('phone', $this->code,true);

        $criteria->compare('active', $this->active);
        $criteria->compare('created_user_id', $this->created_user_id);
        $criteria->compare('created_dt', $this->created_dt, true);
        $criteria->compare('updated_user_id', $this->updated_user_id);
        $criteria->compare('updated_dt', $this->updated_dt, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
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
