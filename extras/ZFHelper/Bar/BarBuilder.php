<?php
/**
 * Created on 27/01/2010
 *
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * <p>Director of the bar creation process</p>
 */
class ZFHelper_Bar_BarBuilder
{
	/**
	 * @var ZFHelper_Bar_HtmlClassBuilder $bar
	 */
	protected $bar;

	public function setBar(ZFHelper_Bar_HtmlClassBuilder $bar)
	{
		$this->bar = $bar;
		return $this;
	}

	public function getBar()
	{
		return $this->bar;
	}

	/**
	 * @param array $config The configuration options for the bar
	 * @return string The html representation of the bar
	 */
	public function constructBar($config) {
		$this->bar->createHtmlBar();
		$this->checkConfig($config);
		$this->bar->buildContainer($config['container']);
		$this->bar->buildContainerStyle($config['containerStyle']);
		$this->bar->buildBarContext($config['destination']);
		$this->bar->buildTargets($config['target']);
		$this->bar->buildHiddenIcons($config['displayHiddenIcons']);
		$this->bar->buildTitles($config['titles']);
		$this->bar->buildIgnoreList($config['hiddenElements']);
		$this->bar->buildTextBar($config['useText']);
		$this->bar->buildContainerPerElement($config['containerPerElement']);
		//	If we will not use text , then build the default image
		if( $config['useText']!=true )
		{
			$this->bar->buildDefaultImage($config['defaultImage']);
		}
		$this->bar->buildContainerCloseTag($config['containerCloseTag']);
		//  Push the current user credentials
		$this->bar->setCredentials( Zend_Auth::getInstance() );
		return $this->bar->yield();
	}

	/**
	 * Review the indexes of the array
	 * @param array $config
	 */
	private function checkConfig(&$config) {

		if( empty($config['container']) )
		{
			$config['container'] = "<div class='%s'>";
		}

		if( empty($config['destination']) )
		{
			$config['destination'] = null;
		}

		if( empty($config['containerStyle']))
		{
			$config['containerStyle'] = 'controller';
		}

		if( empty($config['target']) )
		{
			$config['target'] = null;
		}

		if( empty($config['displayHiddenIcons']) )
		{
			$config['displayHiddenIcons'] = false;
		}

		if( empty($config['defaultImage']) )
		{
			$config['defaultImage'] = null;
		}

		if( empty($config['containerCloseTag']) )
		{
			$config['containerCloseTag'] = "</div>";
		}

		if( empty($config['hiddenElements']) )
		{
			$config['hiddenElements'] = array(null);
		}

		if( empty($config['titles']) )
		{
			$config['titles'] = array(null);
		}

		if( empty($config['useText']) )
		{
			$config['useText'] = false;
		}
		
		if( !isset($config['containerPerElement']) )
		{
			$config['containerPerElement'] = false;
		}
	}
}
?>