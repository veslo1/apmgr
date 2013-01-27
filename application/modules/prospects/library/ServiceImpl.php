<?php
/**
 * Concrete implementation of the Services layer for prospects
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.modules.prospects.library
 */

class Prospects_Library_ServiceImpl implements Prospects_Library_Service
{
  /**
   *
   * Message state that holds tokens and the type of error
   * @var array $msg
   */
  private $msg;

  /**
   * 
   * Sort helper
   * @param ZFDb_SortHelper
   */
  private $sortHelper;

  /**
   *
   * Set's the dao for this object
   * @var ZFInterfaces_Dao
   */
  private $dao;

  /**
   * 
   * The dao interface for prospect answers
   * @var ZFDao_Dao
   */
  private $prospectAnswersDao;

  /**
   * 
   * Set the dao for unit model
   * @var ZFDao_Dao
   */
  private $unitModelDao;

  public function __construct()
  {}

  /**
   * (non-PHPdoc)
   * @see library/ZFInterfaces/ZFInterfaces_Messageable::setMessageState()
   */
  public function setMessageState($msg)
  {
    $this->msg = $msg;
  }

  /**
   * (non-PHPdoc)
   * @see library/ZFInterfaces/ZFInterfaces_Messageable::getMessageState()
   */
  public function getMessageState()
  {
    return $this->msg;
  }

  /**
   *
   * set the dao
   * @param ZFInterfaces_Dao $dao
   */
  public function setDao(ZFInterfaces_Dao $dao)
  {
    $this->dao = $dao;
  }

  /**
   *
   * Retrieve teh dao
   * @return ZFInterfaces_Dao
   */
  public function getDao()
  {
    return $this->dao;
  }

  /**
   * 
   * Set the dao for prospect answers
   * @param ZFDao_Dao $dao
   */
  public function setProspectAnswersDao(ZFDao_Dao $dao)
  {
    $this->prospectAnswersDao = $dao;
  }

  /**
   * 
   * Retrieve the DAO for prospect answers
   * @return ZFDao_Dao
   */
  public function getProspectAnswersDao()
  {
    return $this->prospectAnswersDao;
  }

  /**
   * 
   * Set the dao for unit models
   * @param ZFDao_Dao $dao
   */
  public function setUnitModelDao(ZFDao_Dao $dao)
  {
    $this->unitModelDao = $dao;
  }

  /**
   * 
   * Retrieve the DAO for unit models
   * @return ZFDao_Dao
   */
  public function getUnitModelDao()
  {
    return $this->unitModelDao;
  }
  /**
   * (non-PHPdoc)
   * @see application/modules/prospects/library/Prospects_Library_Service::save()
   */
  public function save(array $prospect)
  {
    return false;
  }

  /**
   * (non-PHPdoc)
   * @see application/modules/prospects/library/Prospects_Library_Service::saveCollection()
   */
  public function saveTransaction(array $args)
  {
    $args = $this->prepareSave($args);
    $prospect = new Prospects_Model_Prospects($args);
    $prospectAnswer = new Prospects_Model_ProspectsUnitIdAnswer();
    $daoAnswer = new Prospects_Library_Dao();
    $daoAnswer->setTemplate(new Prospects_Model_DbTable_ProspectsUnitIdAnswer());
    $opts = array('prospect'=>$prospect,'prospectAnswer'=>$prospectAnswer,'daoAnswer'=>$daoAnswer,'payload'=>$args);
    $saved = $this->dao->saveTransaction($opts);
    if ( $saved ==false )
    {
      $this->setMessageState(array('msg'=>'prospectSaveFail','type'=>'error'));
    }
    return $saved;
  }

  /**
   * (non-PHPdoc)
   * @see application/modules/prospects/library/Prospects_Library_Service::update()
   */
  public function update(array $prospect)
  {
    return false;
  }

  /**
   * (non-PHPdoc)
   * @see application/modules/prospects/library/Prospects_Library_Service::delete()
   */
  public function delete($id)
  {
    return false;
  }

  /**
   * (non-PHPdoc)
   * @see application/modules/prospects/library/Prospects_Library_Service::findById()
   */
  public function findById($id)
  {
    $prospect = null;
    $prospect = $this->dao->findById($id);
    if($prospect==null)
    {
      $this->setMessageState(array('msg'=>'prospectNotFound','type'=>'warning'));
    }
    return $prospect;
  }

  /**
   * (non-PHPdoc)
   * @see application/modules/prospects/library/Prospects_Library_Service::fetchAll()
   */
  public function fetchAll($where=null, $order=null, $count=null, $offset=null)
  {
    $list = $this->dao->fetchAll($where,$order,$count,$offset);

    $prospects = array();
    if($list!==null)
    {
      foreach($list->toArray() as $prospect)
      {
        $prospects[] = new Prospects_Model_Prospects($prospect);
      }
    }
    return $prospects;
  }

  /**
   * (non-PHPdoc)
   * @see application/modules/prospects/library/Prospects_Library_Service::getForm()
   */
  public function getForm(array $args)
  {
    //TODO Allow a collection of dat's to be injected
    $form = null;
    if( isset($args['name']) )
    {
      $form = new $args['name'];
      if( isset($args['dao']) )
      {
        $form->setDao($args['dao']);
      }

      if( isset($args['set']) )
      {
        $form->setForm();
      }

      if( isset($args['payload'])  )
      {
        if( is_array($args['payload']) )
        {
          $form->populate($args['payload']);
        }
      }
    }
    return $form;
  }

  /**
   * (non-PHPdoc)
   * @see application/modules/prospects/library/Prospects_Library_Service::prepareSave()
   */
  public function prepareSave(array $args)
  {
    if( empty($args['rentRangeFrom']) )
    {
      $args['rentRangeFrom'] = 0;
    }

    if( empty($args['rentRangeTo']) )
    {
      $args['rentRangeTo'] = 0;
    }
    if( empty($args['modelType']) )
    {
      $this->setMessageState(array('msg'=>'modelTypeIsRequired','type'=>'error'));
      throw new Exception('The model type is required');
    }

    if( empty($args['phone']) )
    {
      $this->setMessageState(array('msg'=>'phoneIsRequired','type'=>'error'));
      throw new Exception('The phone is required');
    }
    return $args;
  }

  /**
   * 
   * Set the sort helper
   * @param ZFDb_SortHelper $helper
   */
  public function setSortHelper(ZFDb_SortHelper $helper)
  {
    $this->sortHelper = $helper;
  }

  /**
   * 
   * Retrieve the sort helper
   * @return ZFDb_SortHelper
   */
  public function getSortHelper()
  {
    return $this->sortHelper;
  }

  /**
   * 
   * Retrieves all the prospect users and prepare this object to receive pagination
   * @throws Exception
   */
  public function viewAllProspects()
  {
    $prospects = array();
    if($this->sortHelper==null)
    {
      throw new Exception('Sort helper not working');
    }
    $this->sortHelper->setValidColumn(array('possibleMoveInDate','firstName','lastName'));
    $order =  null;
    if ( $this->sortHelper->isSorting() == true )
    {
      $order = $this->sortHelper->prepareOrderQuery();
      $count = null;
      $offset = null;
    }
    else
    {
      $order = "dateCreated";
      $count = 60;
      $offset = 0;
    }
    $list =  $this->fetchAll(null,$order,$count,$offset);
    if( count($list)> 0 )
    {
      foreach($list as $id=>$object)
      {
        $prospects[] = $object->toArray();
      }
    }
    return $prospects;
  }

  /**
   * 
   * Retrieve the given prospect and returns a rehusable structure
   * @param int $id
   */
  public function viewProspectId($id)
  {

    $prospect = $this->findById($id);
    $response = array();
    if(count($prospect)>0)
    {
      $response = array('prospect'=>$prospect);
      //  Patched up , the & is deprecated
      $this->transformResponse($response);
      $answers = $this->prospectAnswersDao->fetchAll( $this->dao->getGateway()->quoteInto('prospectId=?',$id,'integer'));
      $list = $answers->toArray();
      if( count($list)>0 )
      {
        $unitModels = array();
        foreach($list as $id=>$answer)
        {
          $buffer = $this->unitModelDao->findById($answer['unitModelId']);
          if( $buffer!=null )
          {
            $unitModels[] = array_shift($buffer);
          }
        }
        $response['models'] = $unitModels;
      }
      else
      {
        $this->setMessageState(array('msg'=>'prospectRecordDamaged','type'=>'warning'));
        throw new Exception('The current prospect did not select any kind of unit model.Record corrupted');
      }
    }
    return $response;
  }

  protected function transformResponse(array &$response)
  {
    $form = new Prospects_Form_Add();
    $mode = $form->getContactMode();
    $response['prospect']['contactMode'] = $mode[$response['prospect']['contactMode']];
    $response['prospect']['pets'] = Prospects_Form_Add::$answer[$response['prospect']['pets']];
//  If this was an int , then i don't need to do that
//    $response['prospect']['occupants'] = Prospects_Form_Add::$answer[$response['prospect']['occupants']];
    $status = $form->getStatus();
    $response['prospect']['status'] = $status[$response['prospect']['status']];
  }
}
