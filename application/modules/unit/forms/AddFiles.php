<?php
/**
 * Form that allows the user to upload images, videos into the application
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package application.modules.unit.forms
 */
class Unit_Form_AddFiles extends ZFForm_ParentForm
{
	/**
	 * Configuration properties for the form
	 * @var Zend_Config_Ini
	 */
	private $properties;

	/**
	 * Contains the options for this form
	 * @param Zend_Config $properties
	 */
	public function setProperties(Zend_Config $properties)
	{
		$this->properties = $properties;
	}

	/**
	 * Retrieve the configuration properties
	 * @return Zend_Config_Ini
	 */
	public function getProperties()
	{
		return $this->properties;
	}

	/* (non-PHPdoc)
	 * @see library/Zend/Zend_Form::init()
	 */
	public function init()
	{
		$this->setFormTranslator();
		$this->setMethod('post');
		$this->setAttrib('enctype', 'multipart/form-data');
	}
	
	public function setForm()
	{
		if( !isset($this->properties) )
		{
			throw new Exception('The options were not injected');
		}
		$this->addDescription();		
		$this->addFileTransferInput();		
		$this->setLegend($this->properties->pictures->form->legend);
		$this->addSubmitButton();
		$this->setDisplayGroup();
	}
	
	public function addFileTransferInput()
	{
		$element = 'picture';
		$config = $this->properties;		
		
		$options = array('label'     => 'fileAdd',
                          'required'  => false,
                          'filters'   => array('StringTrim'),
                          'destination'=>$config->pictures->files->destination
		);		
		$this->addElement('file',$element,$options);		
                
		//TODO Fix the size part, that is in bytes
		$this->getElement($element)->addValidator('Count', false, 1)
			->addValidator('Size', false, 2097152)
			->addValidator('Extension', false, $config->pictures->allowedfiles)
			->addValidator('Count', false, array('max' => $config->pictures->maxfiles))
			->setDecorators(array('File'),array('CustomForm'))
			->setOptions(array('useByteString' => false));
//		$this->applyDecorator($element);
		$this->getElement($element)->setDecorators(array('File'));
		$this->addToGroup($element);
	}
	
	/**
	 * Adds a description element into the form
	 */
	public function addDescription()
	{
		$element = 'description';
		$options = array( 'label'=>'description', 'cols'=>50, 'rows'=>10, 'required'=>false, 'description'=>'metadataDescription' );
		$this->addElement('textarea',$element,$options);
		$this->addToGroup($element);
	}
	
	/**
	 * 
	 * Transfer a file
	 */
	public function receive()
	{
		return $this->getElement('picture')->receive();
	}
	
	/**
	 * 
	 * Wrap up the element to receive the file information
	 */
	public function getFileInfo()
	{
		return $this->getElement('picture')->getFileInfo();
	}
}
?>