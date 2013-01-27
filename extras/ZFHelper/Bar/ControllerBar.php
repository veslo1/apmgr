<?php
/**
 * Created on 27/01/2010
 *
 * @author Jorge
 * <p>This is the controller bar</p>
 */
class ZFHelper_Bar_ControllerBar extends ZFHelper_Bar_HtmlClassBuilder {

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
	 * Configure the hidden list
	 * @param array $list
	 */
	public function buildIgnoreList($list) {
		$this->htmlBar->setHiddenList($list);
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
		$style = $style==null?'controller':$style;
		$this->htmlBar->setContainerStyle($style);
	}

	/**
	 * Set the main configuration of this bar
	 * @param string $destination
	 * @throws Exception
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
	 * Determine if the bar should build hidden icons
	 * @param boolean $display
	 */
	public function buildHiddenIcons($displayHiddenIcons) {
		$this->htmlBar->setDisplayHiddenIcons($displayHiddenIcons);
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
	 * Set the property
	 * @param $buildTextBar
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
	
	/* (non-PHPdoc)
	 * @see library/ZFHelper/Bar/ZFHelper_Bar_HtmlClassBuilder::yield()
	 */
	public function yield()
	{
		$main = new Modules_Model_Controllers();
		$baseurl = Zend_Controller_Front :: getInstance()->getBaseUrl() ? Zend_Controller_Front :: getInstance()->getBaseUrl() : "/";

		$actions = $this->htmlBar->getContainer();
		$url ='#';
		$displayHiddenIcons = $this->htmlBar->getDisplayHiddenIcons();
		$hiddenList = $this->htmlBar->getHiddenList();
		$useText = $this->htmlBar->getTextBar();
		$roles = $this->mergeCredentials($this->getCredentials());

		
		$data = $main->fetchControllersForModule($this->htmlBar->getDestination(),$roles);	
		$targetArray = $this->flattenTargetQuery();
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
		foreach ( $data as $id => $object )
		{
			/* ticket 331 - for now putting this code (display=1) in the query call.  the intent of this line below was to originally
			  account for a scenario where display is 0 in db but maybe we need to show it for another role. or we need to hide for one
			  role specifically.
			*/
			//if( ($object['display']==true or $displayHiddenIcons==true) and !in_array($object['controllerName'],$hiddenList) )
			if( !in_array($object['controllerName'],$hiddenList) )
			{				
				if ($object['icon'] == null)
				{
					$object['icon']= $this->htmlBar->getDefaultImage();
				}
				//  Build the url							
				$url = $baseurl.$object['moduleName'].'/'. $object['controllerName'].'/';																
				$target = $this->buildQueryString(array('action'=>$object['controllerName'],'targetArray'=>$targetArray));
				if( $target ) { // if target, append to end of url
					$url .= '/'.$target;
				}

				$title = $this->getTitleString($object['controllerName']); // pull title or translated title
				if( true == $useText)
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
	 * With the current credentials, retrieve the user roles
	 * @param Zend_Auth $auth
	 * @return string
	 */
	private function mergeCredentials(Zend_Auth $auth)
	{
		$perms = Zend_Registry::get('properties');
		$roleId = $perms->appsettings->role->request;
		$auth->setStorage(new Zend_Auth_Storage_Session('vazneyStorage'));
		$identity = $auth->getIdentity();
		if ( $identity )
		{
			$roleId = $identity->roleId;
		}
		return $roleId;
	}
}
?>