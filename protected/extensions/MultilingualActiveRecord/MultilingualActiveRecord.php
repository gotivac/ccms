<?php

class MultilingualActiveRecord extends CActiveRecord
{
  
  protected $_langAttributes=array();
  protected $overwriteIfEmpty = false;

	public function __get($name)
	{
		if(array_key_exists($name, $this->_langAttributes))
			return $this->_langAttributes[$name];
		else
			return parent::__get($name);
	}

	public function __set($name,$value)
	{
		if(array_key_exists($name, $this->_langAttributes))
        $this->_langAttributes[$name] = $value;
    else
				parent::__set($name,$value);
	}
  
	public function __isset($name)
	{
		if(isset($this->_langAttributes[$name]))
			return true;
		else
			return parent::__isset($name);
	}

  /**
	 * @return array attributes to look for in the related model
	 */ 
  public function localizedAttributes() {
    return array();
  }
    
  /**
	 * @return array languages
	 */ 
  public function languages() {
    return array();
  }
  
  /**
	 * @return string 
	 */
  public function primaryLang() {
    return null;
  }
  
  /**
	 * @return string 
	 */
  public function langClassName() {
    // return $this->tableName().'Lang';
      return get_class($this).'Lang';
  }
  
  /**
	 * @return string 
	 */
  public function langForeignKey() {
    return strtolower($this->tableName()).'_id';
  }
  
  /**
	 * @return string 
	 */
  public function langField() {
    return 'lang';
  }
  
  
  public function localized($lang=null) {
    if (!$lang) $lang = Yii::app()->language;
    if ($lang == $this->primaryLang()) return $this;
    $class = self::HAS_MANY;
    $options = array('index'=>$this->langField(), 'condition' => "localized.".$this->langField()."='{$lang}'");
    $this->getMetaData()->relations['localized'] = new $class('localized', $this->langClassName(), $this->langForeignKey(),$options);
    return $this->with('localized');
  }
  
  public function multilingual() {
    $class = self::HAS_MANY;
    $options = array('index'=>$this->langField());
    $this->getMetaData()->relations['multilingual'] = new $class('multilingual', $this->langClassName(), $this->langForeignKey(),$options);
    return $this->with('multilingual');
  }
  
  protected function afterFind() {
    if ($this->hasRelated('localized')) {
      $fields = $this->localizedAttributes();
      $related = $this->getRelated('localized');
      if ($row = current($related)) {
        foreach ($fields as $field)
          if ($row[$field] || $this->overwriteIfEmpty) $this->$field = $row[$field];
      }
    } else if ($this->hasRelated('multilingual')) {
      $fields = $this->localizedAttributes();
      $related = $this->getRelated('multilingual');
      $languages = $this->languages();
      foreach ($languages as $lang)
        foreach ($fields as $field)
          $this->_langAttributes[$field.'_'.$lang]=isset($related[$lang][$field])?$related[$lang][$field]:null; 
    }
    if($this->hasEventHandler('onAfterFind'))
			$this->onAfterFind(new CEvent($this));
  }
  
  protected function afterConstruct() {
    $class = $this->langClassName();
    $obj = new $class;
    $fields = $this->localizedAttributes();
    $languages = $this->languages();
    foreach ($languages as $lang)
      foreach ($fields as $field)
        $this->_langAttributes[$field.'_'.$lang]=$obj->$field;

    if($this->hasEventHandler('onAfterConstruct'))
			$this->onAfterConstruct(new CEvent($this));
  }
  
  protected function afterSave() {
    $class = $this->langClassName();
    $model = call_user_func(array($class, 'model'));
    $languages = $this->languages();
    $langField = $this->langField();
    $foreignKey = $this->langForeignKey();
    $fields = $this->localizedAttributes();

    foreach ($languages as $lang) {
      $obj = $model->find("$foreignKey = :id AND $langField = :lang", array('id' => $this->id, ':lang'=>$lang));

      if (!$obj) {
        $obj = new $class;
        $obj->$langField = $lang;
        $obj->$foreignKey = $this->id;
      }
      foreach ($fields as $field) {
        $f = $field.'_'.$lang;
        $obj->$field = $this->$f;
      }
      $obj->save();
    }
    if($this->hasEventHandler('onAfterSave'))
			$this->onAfterSave(new CEvent($this));
  }
  
  
}

