<?php
/**
 * Created on 27/01/2010
 *
 * @author Jorge
 * <p>This is the controller bar</p>
 */
class ZFHelper_Bar_ActionBar extends ZFHelper_Bar_HtmlClassBuilder {

	/**
	 * (non-PHPdoc)
	 * @see library/ZFHelper/Bar/ZFHelper_Bar_HtmlClassBuilder#buildDefaultImage($image)
	 */
	public function buildDefaultImage($image) {
		if($image==null) {
			$image='/images/24/golden_offer.gif';
		}
		$this->htmlBar->setDefaultImage($image);
	}

	/**
	 * Configure this bar
	 * @param array $targets
	 */
	public function buildTargets($targets) {
		if( is_array($targets) and count($targets) > 0 ) {
			$this->htmlBar->setTargets($targets);
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see library/ZFHelper/Bar/ZFHelper_Bar_HtmlClassBuilder#buildContainer($container)
	 */
	public function buildContainer($container) {
		$this->htmlBar->setContainer($container);
	}

	/**
	 * (non-PHPdoc)
	 * @see library/ZFHelper/Bar/ZFHelper_Bar_HtmlClassBuilder#buildContainerStyle($style)
	 */
	public function buildContainerStyle($style) {
		$style = $style==null?'controller':$style;
		$this->htmlBar->setContainerStyle($style);
	}

	/**
	 * (non-PHPdoc)
	 * @see library/ZFHelper/Bar/ZFHelper_Bar_HtmlClassBuilder#buildBarContext($destination)
	 */
	public function buildBarContext($destination) {
		if($destination!=null) {
			$this->htmlBar->setDestination($destination);
		} else {
			throw new Exception('The current module,action or controller is a required attribute for this object configuration');
		}
		return $this;
	}

	/**
	 * (non-PHPdoc)
	 * @see library/ZFHelper/Bar/ZFHelper_Bar_HtmlClassBuilder#buildHiddenIcons($displayHiddenIcons)
	 */
	public function buildHiddenIcons($display) {
		$this->htmlBar->setDisplayHiddenIcons($display);
	}

	/**
	 * (non-PHPdoc)
	 * @see library/ZFHelper/Bar/ZFHelper_Bar_HtmlClassBuilder#buildTitles($titles)
	 * [207] - add title
	 */
	public function buildTitles($titles) {
		$this->htmlBar->setTitles($titles);
	}

	/**
	 * (non-PHPdoc)
	 * @see library/ZFHelper/Bar/ZFHelper_Bar_HtmlClassBuilder#buildTextBar($buildTextBar)
	 */
	public function buildTextBar($buildTextBar) {
		$this->htmlBar->setTextBar($buildTextBar);
	}

	/**
	 * Retrieve the current credentials
	 * @return Zend_Auth
	 */
	public function getCredentials() {
		return $this->htmlBar->getCredentials();
	}

	/**
	 * Set the credentials
	 * @param Zend_Auth $auth
	 */
	public function setCredentials(Zend_Auth $auth) {
		$this->htmlBar->setCredentials($auth);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see ZFHelper/Bar/ZFHelper_Bar_HtmlClassBuilder::buildContainerPerElement()
	 */
	public function buildContainerPerElement($mode=false)
	{
		$this->htmlBar->setContainerPerElement($mode);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see library/ZFHelper/Bar/ZFHelper_Bar_HtmlClassBuilder#yield()
	 */
	public function yield() {
		$url ='#';
		$actions = new Modules_Model_Actions();
		$baseurl = Zend_Controller_Front :: getInstance()->getBaseUrl() ? Zend_Controller_Front :: getInstance()->getBaseUrl() : "/";
		$dest = $this->htmlBar->getDestination();
		//	Determine if we <strong>really</strong> display hidden icons
		$displayHiddenIcons = $this->htmlBar->getDisplayHiddenIcons();
		//	Else fetch teh hidden list
		$hiddenList = $this->htmlBar->getHiddenList();
		//	Should we use text only ?
		$useText = $this->htmlBar->getTextBar();
		//	Just fetch all for this user
		$actions = $this->retrieveActions($dest['module'],$dest['controller'],$this->mergeCredentials($this->getCredentials()));
		//	And get the possible containers that the user gave us
		$openTag = '';
		$closeTag = '';
		if( $this->htmlBar->getContainerPerElement() == false )
		{
			$htmlbar = $this->htmlBar->getContainer();
		}
		else
		{
			$htmlbar = '';
			$openTag = $this->htmlBar->getContainer();
			$closeTag = $this->htmlBar->getContainerClosingTag();
		}
		$targetArray = $this->flattenTargetQuery();
		foreach ( $actions as $id => $object)
		{
			if( ($object['display']==true or $displayHiddenIcons==true) and !in_array($object['actionName'],$hiddenList) )
			{
				if ($object['icon']== null)
				{
					$object['icon']= $this->htmlBar->getDefaultImage();
				}
				$url = $baseurl.$object['moduleName'].'/'. $object['controllerName'].'/'.$object['actionName'];
				$target=$this->buildQueryString(array('action'=>$object['actionName'],'targetArray'=>$targetArray));
				// if target, append to end of url
				if( $target )
				{ 
					$url .= '/'.$target;
				}
				$title = $this->getTitleString($object['actionName']); // pull title or translated title

				if( true==$useText )
				{
					$htmlbar .= "$openTag<a href='$url'>".$title."</a>$closeTag";
				}
				else
				{
					$htmlbar .= "$openTag<a href='$url'><img src='" . $object['icon']. "' title='<i18n>" . $title . "</i18n>' alt='" . $title . "'/></a>$closeTag";
				}
			}
		}
		$htmlbar .= $this->htmlBar->getContainerClosingTag();

		return $htmlbar;
	}

	/**
	 *  Builds the target
	 */
	public function buildQueryString( $item ){
		$return=null;
		if( !empty( $item['action'] ) && !empty( $item['targetArray'] ) ) {
			$action=$item['action'];
			$targetArray=$item['targetArray'];

			if( array_key_exists( $action, $targetArray ) ){
				$return = $targetArray[$action];
			}
		}
		return $return;
	}

	/**
	 *  flatten target array
	 */
	private function flattenTargetQuery() {
		$targetArray = $this->htmlBar->getTargets();
		$container = null;
		if( $targetArray) {
			// one target per action
			foreach( $targetArray as $id=>$item ) {
				$queryString = $item['queryString'];
				$queryString = preg_replace('/^\//','',$queryString);
				$container[$item['action']]=$queryString;
			}
		}
		return $container;
	}

	/**
	 *  Grabs the title string for the  bar url
	 */
	private function getTitleString( $key ){
		$titleArray = $this->htmlBar->getTitles();
		$title=$key;
		if( array_key_exists($key,$titleArray) ) {
			$title=$titleArray[$key];
		}
		return $title;
	}

	/**
	 * (non-PHPdoc)
	 * @see library/ZFHelper/Bar/ZFHelper_Bar_HtmlClassBuilder#buildContainerCloseTag($container)
	 */
	public function buildContainerCloseTag($tag) {
		$this->htmlBar->setContainerClosingTag($tag);
	}

	/**
	 * Configure the hidden list
	 * @param array $list
	 */
	public function buildIgnoreList($list) {
		$this->htmlBar->setHiddenList($list);
	}

	/**
	 * With the current credentials, retrieve the user roles
	 * @param Zend_Auth $auth
	 * @return string
	 */
	private function mergeCredentials(Zend_Auth $auth) {
		$roleId = 3;
		$auth->setStorage(new Zend_Auth_Storage_Session('vazneyStorage'));
		$identity = $auth->getIdentity();
		if ( $identity )
		{
			$roleId = $identity->roleId;
		}
		return $roleId;
	}

	/**
	 * Retrieve all the valid actions for the current role in the given module
	 * @param string $module
	 * @param string $controller
	 * @param string $role
	 * @return array
	 */
	private function retrieveActions($module,$controller,$roles) {
		$tuple = array();

		if( !empty($module) and strlen($module)>0 and !empty($controller) and strlen($controller)>0 )
		{
			$action = new Modules_Model_Actions();
			$db = $action->getDbTable()->getAdapter();
			$select = $db->select()
						 ->from(array('A' => 'actions'),array('actionId'=>'A.id','actionName'=>'LOWER(A.name)','display'=>'A.display','icon'=>'A.icon'))
						->join(array('P'=>'permission'),'A.id = P.actionId',array('permissionId'=>'P.id'))
						->join(array('C'=>'controllers'),'P.controllerId = C.id',array('controllerId'=>'C.id','controllerName'=>'LOWER(C.name)'))
						->join(array('M'=>'modules'),'P.moduleId = M.id',array('moduleId'=>'M.id','moduleName'=>'LOWER(M.name)'))
						->join( array('RP'=>'rolePermission'),'RP.permissionId=P.id',array())
						->where($db->quoteInto('M.name=?',$module,'string'))
						->where($db->quoteInto('C.name=?',$controller,'string'))
						->where($db->quoteInto('RP.roleId =?',$roles,'int'))
						->group('A.id');
			$resultset = $db->query($select);

			if( count($resultset) > 0 )
			{
				foreach ( $resultset as $row )
				{
					$tuple[] = array(
                            'moduleId'=>$row['moduleId'],
                            'moduleName'=>$row['moduleName'],
                            'controllerId'=>$row['controllerId'],
                            'controllerName'=>$row['controllerName'],
                            'actionId'=>$row['actionId'],
                            'actionName'=>$row['actionName'],
                            'icon' => $row['icon'],
                            'display'=>$row['display']
					);
				}
			}
		}
		return $tuple;
	}
}
?>
