<?php
/**
 * Created on 27/01/2010
 *
 * @author Jorge
 * <p>This is the controller bar</p>
 */
class ZFHelper_Bar_ModuleBar extends ZFHelper_Bar_HtmlClassBuilder {

	/**
	 * Set the default image for the bar
	 * @param string $image
	 * @return ZFHelper_Bar_ControllerBar
	 */
	public function buildDefaultImage($image) {
		if($image==null) {
			$image='/images/24/golden_offer.gif';
		}
		$this->htmlBar->setDefaultImage($image);
		return $this;
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
	 * Configure the container for this docklet
	 * @param string $container
	 */
	public function buildContainer($container) {
		if($container==null) {
			$container = "<div class='%s'>";
		}

		$this->htmlBar->setContainer($container);
	}

	/**
	 * @param string $tag
	 */
	public function buildContainerCloseTag($tag) {
		$this->htmlBar->setContainerClosingTag($tag);
	}

	/**
	 * Configure the style for this container bar
	 * @param string $style
	 */
	public function buildContainerStyle($style) {
		$style = $style==null?'dashboard':$style;
		$this->htmlBar->setContainerStyle($style);
	}

	/**
	 * Set the main configuration of this bar
	 * @param string $destination
	 * @throws Exception
	 */
	public function buildBarContext($destination) {
		$this->htmlBar->setDestination($destination);
		return $this;
	}

	/**
	 * Determine if the bar should build hidden icons
	 * @param boolean $display
	 */
	public function buildHiddenIcons($displayHiddenIcons) {
		$this->htmlBar->setDisplayHiddenIcons($displayHiddenIcons);
	}

	/**
	 * (non-PHPdoc)
	 * @see ZFHelper/Bar/ZFHelper_Bar_HtmlClassBuilder::buildTitles()
	 */
	public function buildTitles($titles)
	{
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
	 * (non-PHPdoc)
	 * @see ZFHelper/Bar/ZFHelper_Bar_HtmlClassBuilder::buildContainerPerElement()
	 */
	public function buildContainerPerElement($mode=false)
	{
		$this->htmlBar->setContainerPerElement($mode);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see ZFHelper/Bar/ZFHelper_Bar_HtmlClassBuilder::yield()
	 */
	public function yield()
	{
		$url ='#';
		$baseurl = Zend_Controller_Front :: getInstance()->getBaseUrl() ? Zend_Controller_Front :: getInstance()->getBaseUrl() : "/";
		$actions = $this->htmlBar->getContainer();
		$displayHiddenIcons = $this->htmlBar->getDisplayHiddenIcons();
		$hiddenList = $this->htmlBar->getHiddenList();	
			
		$useText = $this->htmlBar->getTextBar();
		$modules = $this->retrieveModules($this->mergeCredentials($this->getCredentials()));
		$targetArray = $this->flattenTargetQuery();
		//	If we decide to build with a custom wrapper , then
		$openTag = '';
		$closeTag = '';
		if( $this->htmlBar->getContainerPerElement() == false )
		{
			$actions = $this->htmlBar->getContainer();
		}
		else
		{
			$actions = '';
			$openTag = $this->htmlBar->getContainer();
			$closeTag = $this->htmlBar->getContainerClosingTag();
		}

		foreach ($modules as $id => $object)
		{
			if( ($object['display']==true or $displayHiddenIcons==true) and !in_array($object['name'],$hiddenList) )
			{
				if ($object['icon'] == null)
				{
					$object['image'] = $this->htmlBar->getDefaultImage();
				}				
				$url = $baseurl.$object['name'];																
				$target = $this->buildQueryString(array('action'=>$object['name'],'targetArray'=>$targetArray));							
                if( $target )
                { 
                	// if target, append to end of url
					$url .= '/'.$target;
				}
				$title = $this->getTitleString($object['name']); // pull title or translated title				
				
				if( true==$useText )
				{
					$actions .= "$openTag<a href='$url'>".$title."</a>$closeTag";
				}
				else
				{
					$actions .= "$openTag<a href='$url'><img src='" . $object['icon']. "' title='<i18n>" . $title . "</i18n>' alt='" . $title . "'/></a>$closeTag";
				}
				// And clean it
				$this->buildQueryString('');
			}
		}

		$actions .= $this->htmlBar->getContainerClosingTag();

		return $actions;
	}

	/**
	 *  Grabs the title string for the  bar url
	 */
	private function getTitleString( $key )
	{
		$titleArray = $this->htmlBar->getTitles();
		$title = $key;
		if( array_key_exists($key,$titleArray) )
		{
			$title=$titleArray[$key];
		}
		else 
		{
			//	$translator = Zend_Registry::get('Zend_Translate');
			//	$title = $translator->_($key);
			//	Upercase the text that we receive
			$title = ucfirst($key);
		}
		return $title;
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
	 * Configure the hidden list
	 * @param array $list
	 */
	public function buildIgnoreList($list) {
		$this->htmlBar->setHiddenList($list);
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
	 * With the current credentials, retrieve the user roles
	 * @param Zend_Auth $auth
	 * @return string
	 */
	private function mergeCredentials(Zend_Auth $auth)
	{
		$perms = Zend_Registry::get('properties');
		$roleId = $perms->appsettings->role->request;
//		$roleId = 4; // guest role
		$auth->setStorage(new Zend_Auth_Storage_Session('vazneyStorage'));
		$identity = $auth->getIdentity();
		if ( $identity )
		{
			$roleId = $identity->roleId;
		}
		return $roleId;
	}

	/**
	 * Retrieve the current modules for the current user
	 * @param string $role
	 *
	 *
	 *SELECT `M`.`name`, `M`.`icon`, `M`.`display`,C.name 
FROM `modules` AS `M`
 INNER JOIN `permission` AS `P` ON P.moduleId = M.id 
 INNER JOIN `rolePermission` AS `RP` ON RP.permissionId=P.id 
 INNER JOIN `controllers` AS C ON P.controllerId=C.id
WHERE (RP.roleId = 4) 
AND C.name='Index'
GROUP BY `M`.`id`
	 * 
	 */
	private function retrieveModules($roles) {
		$list = array();
		$modules = new Modules_Model_Modules();
		$db = $modules->getDbTable()->getAdapter();
		$select = $db->select()
			->from(array('M' => 'modules'),array('name'=>'M.name','icon'=>'M.icon','display'=>'M.display'))
			->join( array('P'=>'permission'),'P.moduleId = M.id',array())
			->join( array('RP'=>'rolePermission'),'RP.permissionId=P.id',array())
			->join(array('C'=>'controllers'),'C.id=P.controllerId',array())
			->join(array('A'=>'actions'),'A.id=P.actionId',array())
			->where('C.name=?','Index')
			->where('A.name=?','Index')
			->where($db->quoteInto('RP.roleId = ?',$roles,'int'))			
			->group('M.id');
		$resultset = $db->query($select);
		if( count($resultset) > 0 )
		{
			foreach($resultset as $id=>$value)
			{				
				$list[]= $value;
			}
		}
		else
		{
			throw new Exception('The modules for this role do not exists');
		}				
		return $list;
	}
}
?>