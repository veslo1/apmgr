<?php
/**
 * Provide a model to work with the ACL
 *
 * @author jvazquez
 */
class Role_Model_RoleAclModel extends ZFModel_ParentModel {

	/**
	 * Assemble the form that you are going to create
	 * @internal This method seems rather expensive to create, and I notice some high load
	 * @param array $pages
	 * @return Ambigous <multitype:, Role_Form_CreateAcl>
	 */
	public function assembleForm($pages) {
		$forms = array();
		foreach($pages as $id=>$content) {
			$aclForm = "<form enctype=\"application/x-www-form-urlencoded\"/ method=\"post\">";
			$aclForm .="<input type=\"hidden\" name=\"permission\" id=\"permission\" value=\"".$content['pageId']."\">";
			$content['roles'] = isset($content['roles'])?$content['roles']:null;
			$this->createRolesForm($aclForm,$content['roles']);
			$aclForm .="<br/><input type=\"submit\" name=\"submit\" id=\"submit\" value=\"<i18n>save</i18n>\"/>";
			$aclForm .="</form>";
			$forms[$content['pageId']] = $aclForm;
		}
		//	And clean the cache
		$cache = Zend_Registry::get('cache');
		$cache->remove('rolesSelectAcl');
		return $forms;
	}

	/**
	 * Retrieve the form as a string and create an input control inside of the form
	 * @param string $aclForm
	 * @param array $currentRoles
	 * @return string
	 */
	protected function createRolesForm(&$aclForm,$currentRoles) {
		$role = new Role_Model_Role();
		$roleArray = array();
		$cache = Zend_Registry::get('cache');
		$roleArray = $cache->load('roleCacheAclForm');

		if( $roleArray==false ) {
			foreach( $role->fetchAll() as $id=>$roleContent ) {
				$roleArray[$roleContent->getId()] = array('id'=>$roleContent->getId(),'name'=>$roleContent->getName());
			}
			$cache->save($roleArray,'roleCacheAclForm');
		}

		if( isset($currentRoles) ) {
			foreach($currentRoles as $id=>$content) {
				if( in_array($content['roleId'],array_keys($roleArray)) ) {
					$roleArray[$content['roleId']]['selected'] = true;
				}
			}
		}

		$aclForm.="<select name=\"roleId[]\" id=\"roleId\" multiple=\"multiple\">";
		foreach($roleArray as $id=>$mixedResult) {
			if(isset($mixedResult['selected']) ) {
				$aclForm .="<option label=\"".$mixedResult['name']."\" value=\"".$mixedResult['id']."\" selected=\"true\">".ucfirst($mixedResult['name'])."</option>";
			} else {
				$aclForm .="<option label=\"".$mixedResult['name']."\" value=\"".$mixedResult['id']."\" >".ucfirst($mixedResult['name'])."</option>";
			}
		}
		$aclForm.="</select>";
	}
}
?>