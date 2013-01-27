<?php
/**
 * Helper for File
 */

class File_Library_FileHelper implements ZFInterfaces_Messageable{				
	/**
	 * Set the message state
	 * @param $msg
	 */
	public function setMessageState($msg){
		$this->msg = $msg;
		return $this;
	}
	
	public function getMessageState(){
		return $this->msg;
	}
	
	/**
	 * Implementation of the magic method
	 * @return string
	 */
	public function __toString()
	{
		return "FileHelper";
	}
	
	/**
	 *  Returns info about the file
	 */
	public function getFile($id){
		$fileObj = new File_Model_File();		
		$file = $fileObj->findById( $id );
		
		$return = false;
		
		if( $file ) {	
			$path = $file->getFullPath();			
			if( file_exists($path) ){
			    $docs = array();			    			  
			    $docs['description'] = $file->getDescription();
			    $docs['fullPath'] = $file->getFullPath();
			    $docs['name'] = $file->getFileName();
			    $docs['type'] = $file->getMimeType();
                            $return = $docs;			    
			}
			else{
			    $this->setMessageState('fileNotFound');  // boolean?  haha
			}			
		}
		else{
			$this->setMessageState('fileNotFound');  // boolean?  haha
		}
		return $return;
	}
	
	/**
	 *  Delete file
	 */
	public function deleteFile($id){
		$fileObj = new File_Model_File();
		$file = $fileObj->findById( $id );
		
		$return = false;
		if( $file ) {
		    $file->setDeleted(1);
		    $result = $file->save();
		   
		    if( $result ) {
			$this->setMessageState('fileDeleted');
			$result = true;
		    }
		    else{
			$this->setMessageState('errorDeletingFile');
		    }		    
		}
		return $return;
	}
}