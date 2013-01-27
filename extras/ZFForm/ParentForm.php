<?php
/**
 *   Lame parent form for doing stuff that is reused in forms
 */
class ZFForm_ParentForm extends Zend_Form {

  /**
   * The states
   * @var array
   */
  static $states = array('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY') ;

  /**
   * Genders
   * @var array
   */
  static $sex = array('m','f');

  /**
   * Basic yes / no
   * @var array
   */
  static $answer = array('yes','no');

  /**
   * Valid statuses for people
   * @var array
   */
  static $marital = array('single','married','divorced','widowed','separated');

  /**
   * list
   * @var array
   */
  protected $displayGroupArray;

  /**
   * The default decorator that is used
   * @var const
   */
  const DEFAULT_PREFIX='ZFForm_Decorator';

  /**
   * Default path for the decorator
   * @var const
   */
  const DEFAULT_PATH = 'ZFForm/Decorator';

  /**
   * Default type of object that is applied to the element you are using
   * @var const
   */
  const DEFAULT_TYPE = 'decorator';

  /**
   * Default decorator used
   * @var const
   */
  static $DEFAULTDECORATOR=array('FieldsetForm');

  /**
   * Cache implementation
   * @var Zend_Cache
   */
  protected $cache;

  /**
   * Unique identifier for your cached values
   * @var string $cacheKey
   */
  protected $cacheKey;

  /**
   * Flag field that determines when the Cache object is forced to be clean.
   * When a signal is caught (cache->clean call) , we will toggle this on
   * @var boolean
   */
  protected $signaled;

  /**
   * Enter description here ...
   */
  public function __construct() {
    parent::__construct();
    $this->setMethod('post');
    $this->displayGroupArray = array();		
    $this->signaled = false;
  }

  /**
   *  Pushes element to array group
   */
  public function addToGroup($var){
    array_push( $this->displayGroupArray, $var );
  }

  /**
   *  Adds the Submit button to form
   *  @param string $label The label to use in this element
   */
  protected function addSubmitButton($label='save',$element='submit'){
    $this->addElement('submit', $element, array('ignore'=> true, 'label' =>$label) );
    $this->getElement($element)->setAttrib('class','submit');
    $this->getElement($element)->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
    $this->getElement($element)->setDecorators(array('FieldsetForm'));
    $this->addToGroup($element);
  }


  /**
   * Sets the decorator.  currently used for the fiedlset forms with inputAccessible/NotAccessible
   * @param string $element
   * @param boolean $inaccessible
   */
  protected function applyDecorator($element, $inaccessible=false){
    $class='inputAccesible';

    if( $inaccessible===true ) {
      $class='inputNotAccesible';
    }

    $this->getElement($element)->setAttrib('class',$class);
    $this->getElement($element)->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
    $this->getElement($element)->setDecorators(array('FieldsetForm'));
  }

  /**
   * Apply custom decorators
   * @param array $prefix
   * @param array $decorators
   */
  protected function addCustomDecorator(array $prefix,array $decorators,$element){
    $prefix['prefix'] = !isset($prefix['prefix'])?self::DEFAULT_PREFIX:$prefix['prefix'];
    $prefix['path'] = !isset($prefix['path'])?self::DEFAULT_PATH:$prefix['path'];
    $prefix['type'] = !isset($prefix['decorator']) ? self::DEFAULT_TYPE:$prefix['type'];
    $decorators = !isset($decorators) ?self::$DEFAULTDECORATOR:$decorators;
    $this->getElement($element)->addPrefixPath($prefix['prefix'], $prefix['path'],$prefix['type']);
    $this->getElement($element)->clearDecorators();
    $this->getElement($element)->setDecorators($decorators);
  }

  /**
   * Sets the display group.Uses the set Legend
   * @param string $name
   */
  protected function setDisplayGroup($name='displayGroup'){
    $this->addDisplayGroup($this->displayGroupArray,$name,array('legend' => $this->getLegend()));
    $this->getDisplayGroup($name)->setDecorators(array('FormElements','Fieldset'));
  }

  /**
   *  Sets the translator for the form
   */
  protected function setFormTranslator() {
    $this->setTranslator( Zend_Registry::get('Zend_Translate') );
  }


  /**
   * Add decorator and group in one line
   * @param string $element
   * @param boolean $inaccessible
   */
  protected function addDecoratorAndGroup($element,$inaccessible=false) {
    $this->applyDecorator($element,$inaccessible);
    $this->addToGroup($element);
  }

  /**
   *  Sets the form to read-only
   */
  public function setFormReadOnly(){
    foreach( $this->getElements() as $id=>$element){
      $element->setRequired(false);
      $element->setAttrib('disabled',true);
      //	And remove submit buttons
      if($element->getType()=='Zend_Form_Element_Submit') {
        $this->removeElement($element->getName());
      }
    }
  }

  /**
   * Set the cache engine
   * @param Zend_Cache $cache
   */
  public function setCache($cache)
  {
    $this->cache = $cache;
  }

  /**
   * Retrieve the instance of the cache
   * @return Zend_Cache
   */
  public function getCache()
  {
    return $this->cache;
  }

  /* (non-PHPdoc)
   * @see library/Zend/Zend_Form::persistData()
   */
  public function persistData()
  {
    $persisted = false;
    $cache = $this->getCache();
    $values = $this->getValues();
    $cacheKey = $this->getCacheKey();
    //	If this 3 simple preconditions are met
    if( !empty($values) and !empty($cache) and !empty($cacheKey) )
    {
      $hasCachedValues = $cache->test($cacheKey);
      //	We never stored in cache
      if(false==$hasCachedValues)
      {
        $persisted=$cache->save($values,$cacheKey);
      }
      else
      {
        $originalValues = $cache->load($cacheKey);
        //	We used cache , so now verify.If we have a difference , then alter.
        $diff = count(array_diff_assoc($originalValues,$values));
        if( $diff>0 )
        {
          //	we toggle signal and inform that a cache clean operation has been executed, so we set the state as clean
          $this->signaled=$this->getCache()->clean(Zend_Cache::CLEANING_MODE_ALL,array($this->getCacheKey()));
          $persisted=$cache->save($values,$cacheKey);
        }
      }
    }
    return $persisted;
  }

  /**
   * Set our cache identifier
   * @param string $key
   */
  public function setCacheKey($key)
  {
    $this->cacheKey = $key;
  }

  /**
   * Retrieve our identifier
   * @return string
   */
  public function getCacheKey()
  {
    return $this->cacheKey;
  }

  /**
   * Retrieve the cached files.
   * The return object will contain a signaled element that will determine if cache was clean
   * @return array
   */
  public function getPersistedData()
  {
    $info = $this->getCache()->load($this->getCacheKey());
    if( false==is_array($info) )
    {
      $info = array();	
    }
    $info['signaled'] = $this->signaled;		
    return $info;
  }

    /**
   * Add a captcha that uses the image
   */
  public function addCaptcha() {
    $element ='captcha';
    $captchaImageOptions = array(
                  'captcha' => 'Image',
                              'font'    => realpath(APPLICATION_PATH.'/../../public_html_apmgr/fonts/VeraMoBI.ttf'),
                              'imgDir'  => realpath(APPLICATION_PATH.'/../../public_html_apmgr/fonts/image/captcha'),
                              'imgUrl'  => '/fonts/image/captcha',
                              'wordLen' => 4,
                              'timeout' => 300,
                  'dotnoiselevel'=>0,
                  'width'=>256,
                  'height'=>64,
                  'fontsize'=>24
                  
    );
    $captchaOptions = array('label' => 'captchainstruction',
                        'required'   => true,
                        'captcha'    => $captchaImageOptions);
    $this->addElement('captcha', $element,$captchaOptions);
    $this->addDecoratorAndGroup($element);    
  }
}
?>
