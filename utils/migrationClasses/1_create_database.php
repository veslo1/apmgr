<?php
//	This is a pain in the ass if i have to define the entire database like this- , YAML does not support UTF-8 and definning relations it's documented, so will try the yaml approach
//http://www.doctrine-project.org/documentation/manual/1_2/ru/defining-models:columns:data-types:enum for enums
class CreateDatabase extends Doctrine_Migration_Base {
	/**
	 *
	 * @return unknown_type
	 */
	public function up() {
		$options = array('type'     => 'INNODB','charset'  => 'utf8');
		//	Account table
		$columns = array(	'id' => array(
         									'type' => 'integer',
							                'autoincrement' => true,
         									'primary'=>true),
            				'name' => array('type' => 'string','length' => 50,'notnull'=>1),
            				'number' => array('type' => 'integer','unsgined' => true,'notnull'=>1),
							'isDiscount'=>array('type'=>'bit','notnull'=>1),
            				'dateCreated'=> array('type'=>'datetime','notnull'=>1),
            				'dateUpdated'=> array('type'=>'datetime','notnull'=>0)
		);
		$this->createTable('account', $columns, $options);
		
	}

	public function down() {
		$this->dropTable('account');
	}
}