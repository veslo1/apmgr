<?php
/**
 * Created on Dec 24, 2009
 * @author jvazquez <jvazquez@debserverp4.com.ar>
 * <p>Form for the ACL.During this form, I found one issue when no validators are appended to a select optio, refer to {@link http://framework.zend.com/manual/en/zend.form.standardElements.html#zend.form.standardElements.select Read it, and you will find out why I'm usning that registerInArrayValidator key}n</p>
 */
class Role_Form_CreateAcl extends Zend_Form {

	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Zend_Form#init()
	 */
	public function init() {
		$translator = Zend_Registry::get('Zend_Translate');
		$this->setMethod('post');
		$selectArgs = array(
                            'label' => 'permissions',
                            'required' => false ,
                            'registerInArrayValidator'=>false
		);
		$this->addElement('multiselect','roleId',$selectArgs);

		$cache = Zend_Registry::get('cache');
		if( !($roleCache = $cache->load( 'rolesSelectAcl' ) ) ) {
			$role = new Role_Model_Role();
			foreach($role->fetchAll() as $id=>$roleData) {
				$roleCache[] = array('id'=>$roleData->getId(),'name'=>ucfirst($roleData->getName()));
			}
			$cache->save($roleCache, 'rolesSelectAcl');
		}

		foreach($roleCache as $id=>$content) {
			$this->getElement('roleId')->addMultiOption($content['id'], $content['name']);
		}

		$this->getElement('roleId')->setAttrib('class','inputAccesible');
		$this->getElement('roleId')->addPrefixPath('ZFForm_Decorator','ZFForm/Decorator','decorator');
		$this->getElement('roleId')->setDecorators(array('CustomForm'));
		$this->addElement('submit', 'submit', array ( 'ignore' => true, 'label' => 'save','translator'=>$translator) );
		$this->getElement('submit')->setDecorators(array('ViewHelper',
		array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
		array(array('label' => 'HtmlTag'), array('tag' => 'td', 'placement' => 'prepend')),
		array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
		)
		);
		$this->setDecorators( array( 'FormElements',array('HtmlTag', array('tag' => 'table')),'Form'));
	}
}
?>