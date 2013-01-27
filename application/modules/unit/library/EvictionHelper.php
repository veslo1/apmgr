<?php
/**
 * Helper for Eviction
 */

class Unit_Library_EvictionHelper implements ZFInterfaces_Messageable{				
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
		return "EvictionHelper";
	}				
	
	/**
	 *  Pulls evictions per lease.  Used on viewevictions page
	 */
	public function fetchLeaseEvictions($leaseId) {
		/*
		   <td><?php echo $row['tenantName']; ?></td>
		   <td><?php echo $row['isEvicted']; ?></td>
		   <td><?php echo $row['dateCreated']; ?></td>
		 */
		
		if( empty($leaseId) ) {		    
			$this->setMessageState('missingLeaseId');
			return false;
		}
		else {		   
		   $lease = new Unit_Model_Lease();
		   $db = $lease->getDbTable()->getAdapter();	   
		   		
		   $select = $db->select()
		   ->from( array('L'=>'lease'),array())			  
		   ->join( array('T'=>'tenant'),'L.id=T.leaseId',array())
		   ->join( array('U'=>'user'),'U.id=T.userId',array('firstName'=>'U.firstName','lastName'=>'U.lastName'))
		   ->join( array('E'=>'eviction'),'E.tenantId=T.id',array('id','isEvicted','dateCreated'))
		   ->where('L.id=?',$leaseId,'int');		   		   	   		
			 
		   $resultSet = $db->query($select);						
		   $container = null;		
		   		    
		   foreach ($resultSet as $row) {
 		      $row['isEvictedText']=($row['isEvicted'])?'yes':'no';
		      $row['tenantName'] = $row['firstName'] . ' ' . $row['lastName'];
		      $container[] = $row;
		   }		   
		   return $container;
		}   
	}
	
	/**
	 *  Pulls an eviction record
	 */
	public function viewEviction($evictionId) {
		/*
		   <td><?php echo $row['tenantName']; ?></td>
		   <td><?php echo $row['isEvicted']; ?></td>
		   <td><?php echo $row['dateCreated']; ?></td>
		 */		
		if( empty($evictionId) ) {		    
			$this->setMessageState('missingEvictionId');
			return false;
		}
		else {		   
		   $lease = new Unit_Model_Lease();
		   $db = $lease->getDbTable()->getAdapter();	   
		   		
		   $select = $db->select()
		   ->from( array('L'=>'lease'),array())			  
		   ->join( array('T'=>'tenant'),'L.id=T.leaseId',array())
		   ->join( array('U'=>'user'),'U.id=T.userId',array('firstName'=>'U.firstName','lastName'=>'U.lastName'))
		   ->join( array('E'=>'eviction'),'E.tenantId=T.id',array('id','isEvicted','dateCreated'))
		   ->where('E.id=?',$evictionId,'int');		   		   	   					 
		   
		   $resultSet = $db->fetchAll($select);		   
		   $container = null;				   
		   		    
		   if( $resultSet ) {			
			$row = array_shift( $resultSet );
			$row['isEvictedText']=($row['isEvicted'])?'yes':'no';
 		        $row['tenantName'] = $row['firstName'] . ' ' . $row['lastName'];
		        $container = $row;			
		   }		  
		   return $container;
		}   
	}
	
	/**
	 *  Pulls eviction comments record
	 */
	public function viewComments($evictionId) {
		/*
		   <td><?php echo $row['tenantName']; ?></td>
		   <td><?php echo $row['isEvicted']; ?></td>
		   <td><?php echo $row['dateCreated']; ?></td>
		 */		
		if( empty($evictionId) ) {		    
			$this->setMessageState('missingEvictionId');
			return false;
		}
		else {		   
		   $lease = new Unit_Model_Lease();
		   $db = $lease->getDbTable()->getAdapter();	   
		   		
		   $select = $db->select()
		   ->from( array('L'=>'lease'),array())			  
		   ->join( array('T'=>'tenant'),'L.id=T.leaseId',array())		   
		   ->join( array('E'=>'eviction'),'E.tenantId=T.id',array())
		   ->join( array('EC'=>'evictionComment'),'E.id=EC.evictionId',array('comment','dateCreated'=>'dateCreated'))
		   ->join( array('U'=>'user'),'U.id=EC.userId',array('firstName'=>'U.firstName','lastName'=>'U.lastName'))
		   ->where('E.id=?',$evictionId,'int');		   		   	   					 
		   
		   $resultSet = $db->query($select);		   
		   $container = null;				   
		   		    
		   if( $resultSet ) {
			foreach ($resultSet as $row) {
		            $container[] = $row;
			}
		   }		  
		   return $container;
		}   
	}
	
	/**
	 *  Creates new eviction
	 *
	 *  array
		'module' => string 'unit' (length=4)
		'controller' => string 'lease' (length=5)
		'action' => string 'createeviction' (length=14)
		'leaseId' => string '4' (length=1)
		'tenantId' => string '3' (length=1)
		'isEvicted' => string '1' (length=1)
		'comment' => string 'test' (length=4)
		'submit' => string 'Save' (length=4)
	 */
	public function createEviction( $args ) {
		$lease = new Unit_Model_Lease();
		$db = $lease->getDbTable()->getAdapter();
		$db->beginTransaction();
		try{
		    $evictionObj = new Unit_Model_Eviction(array('db'=>$db));
		    $evictionObj->setTenantId( $args['tenantId'] );
		    $evictionObj->setIsEvicted( $args['isEvicted'] );
		    $evictionId = $evictionObj->save();
		    
		    $evictionCommentObj = new Unit_Model_EvictionComment(array('db'=>$db));
		    $evictionCommentObj->setEvictionId( $evictionId );
		    $evictionCommentObj->setComment( $args['comment'] );
		    $evictionCommentObj->setUserId( User_Library_Helper_Utils::currentUserId()  );
		    $evictionCommentObj->save();
		    $db->commit();
		    return true;
		}
		catch ( Exception $e) {
			$db->rollBack();			
			return false;
		}
	}
	
	/**
	 *  Save eviction comment
	 */
	public function saveComment( $args ) {
		if( empty($args) ) {
		    $this->setMessageState('missingArguments');
		    return false;
		}
		else {
		    $args['userId'] = User_Library_Helper_Utils::currentUserId();	 
		    $commentObj = new Unit_Model_EvictionComment($args);
		    return $commentObj->save();	    
		}
	}
	
	/**
	 *  Fetch leaseId by evictionId
	 */
	public function fetchLeaseIdByEvictionId( $evictionId ) {
		if( empty($evictionId) ) {		    
			$this->setMessageState('missingEvictionId');
			return false;
		}
		else {		   
		   $lease = new Unit_Model_Lease();
		   $db = $lease->getDbTable()->getAdapter();	   
		   		
		   $select = $db->select()
		   ->from( array('L'=>'lease'),array())			  
		   ->join( array('T'=>'tenant'),'L.id=T.leaseId',array('leaseId'=>'T.leaseId'))		   
		   ->join( array('E'=>'eviction'),'E.tenantId=T.id',array())		  
		   ->where('E.id=?',$evictionId,'int');		   		   	   					 		   
		   
		   $resultSet = $db->fetchCol($select);
		   
		   $container = null;		
		   if( $resultSet ) {			
			$container = array_shift( $resultSet );
		   }		   
		   return $container;		  
		}   
	}
}