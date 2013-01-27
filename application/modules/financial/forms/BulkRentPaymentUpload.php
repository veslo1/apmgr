<?php
/**
 * Form that allows the user to upload csv files to be procesd
 *
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @author Rachael Nelson <wtcfg1@gmail.com>
 */
class Financial_Form_BulkRentPaymentUpload extends Zend_Form {
	/**
	 * Temporal setting until we have a backend
	 * 4mb max upload
	 * @var unknown_type
	 */
	private static $size = 4194304;

	public function init() {
		$this->setLegend('bulkRentPayment');
	}
	public function setForm(){
		$this->setMethod('post');
		// $this->setAttrib('enctype', 'multipart/form-data');
		//$config = new Zend_Config_Ini(APPLICATION_PATH.'/modules/unit/config/config.ini',APPLICATION_ENV);
		 
		$this->addElement('file',
                          'csvfile',
		array(
                            'label'     => 'fileAdd',
                            'required'  => true,
                            'filters'   => array('StringTrim'),
			    'destination'=>'/usr/local/www/apmgr/public/uploads'                         			    
			    )
			    );

			    $this->getElement('csvfile')->addValidator('Count', false, 1)
			    ->addValidator('Size', false, self::$size)
			    ->addValidator('Extension', false, 'csv')
			    ->addValidator('Count', false, array('max' => 1))
			    ->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator')
			    ->setDecorators(array('File'),array('CustomForm'))
			    ->setOptions(array('useByteString' => false));

			    $this->addElement('submit', 'submit', array('ignore'=>true,'label'=>'upload'));
			    $this->getElement('submit')->setAttrib('class','submit');
			    $this->getElement('submit')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
			    $this->getElement('submit')->setDecorators(array('FieldsetForm'));

			    $this->addDisplayGroup(array(
                    'csvfile',		    
		    'submit'        
		    ),'bulkUploadPayment',array('legend' => $this->getLegend()));

		    $this->getDisplayGroup('bulkUploadPayment')->setDecorators(array(
                    'FormElements',
                    'Fieldset',                    
		    ));
	}
}
?>