<?php
/**
 * Description of CalendarHtmlTest
 *
 * @author jvazquez <jvazquez@debserverp4.com.ar>
 */
//require '/usr/local/www/apmgr/application/modules/unit/models/UnitMetadata.php';

class ZFFile_FileTest extends ControllerTestCase {

	public function setUp() {
		parent::setUp();
	}

	public function testSetSize() {
		
		$stubArgs = array('file'=>array ( 'picture'=>array ( 'name' => '3387-turf-houses.jpg', 'type' => 'image/jpeg', 'tmp_name' => '/usr/local/www/apmgr/public/images/uploads/3387-turf-houses.jpg', 'error' => '0', 'size' => '81368', 'options'=> array ( 'ignoreNoFile' => '1', 'useByteString' => '1', 'magicFile' => null, 'detectInfos' => '1',), 'validated' => '1', 'received' => '1', 'filtered' => '1', 'validators'=>array ( '0'=>'Zend_Validate_File_Upload', '1'=>'Zend_Validate_File_Count', '2'=>'Zend_Validate_File_Size', '3'=>'Zend_Validate_File_Extension', '4'=>'Zend_Validate_File_Count',), 'filters'=>array ( '0'=>'Zend_Filter_StringTrim'), 'destination' => '/usr/local/www/apmgr/public/images/uploads') ));
		$zfFile = new ZFFile_File();
		$zfFile->setPath('/usr/local/www/apmgr/public/images/uploads/3387-turf-houses.jpg');
		$zfFile->setSize(81368);
		$zfFile->setName('3387-turf-houses.jpg');
		$zfFile->setType('image/jpeg');
		$this->assertEquals('/usr/local/www/apmgr/public/images/uploads/3387-turf-houses.jpg',$zfFile->getPath());
		$this->assertEquals(81368,$zfFile->getSize());
		$this->assertEquals('3387-turf-houses.jpg',$zfFile->getName());
		$this->assertEquals('image/jpeg',$zfFile->getType());
	}
}