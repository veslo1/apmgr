<?php
/**
 * Helper for Lease
 */

class Unit_Library_LeaseHelper implements ZFInterfaces_Messageable{				
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
		return "LeaseWizardHelper";
	}			
	
		
	/**
	 *  Fetch lease documents for each lease	
	 */	
	public function fetchLeaseDocuments( $leaseId ){	
		
		if( empty($leaseId) ) {		    
			$this->setMessageState('missingLeaseId');
			return false;
		}
		else {		   
		   $leaseFile = new Unit_Model_LeaseFile();
		   $db = $leaseFile->getDbTable()->getAdapter();
		   
		   $src = $leaseFile->getSrc();
		
		   $select = $db->select()
		   ->from( array('F'=>'file'))			  
		   ->join( array('LF'=>'leaseFile'),'LF.fileId=F.id',array('leaseFileId'=>'LF.id','leaseId'=>'LF.leaseId'))
		   ->where('LF.leaseId=?',$leaseId,'int')
		   ->where('deleted=0');		   	   
					
		   $resultSet = $db->query($select);						
		   $container = null;		
		   		    
		   foreach ($resultSet as $row) {
		      $row['path'] = $this->formatPath( $src, $row['path'] );	
		      $container[] = $row;
		   }
		   return $container;
		}   
	}
	
	/**
	 *  Creates source path
	*/
	public function formatPath( $root, $path ){
		return str_replace($root, '', $path);
	}
	
	/**
	 *  Fetches the current user's current or pending leases
	 */
	public function fetchMyCurrentLeases(){
		$userId = User_Library_Helper_Utils::currentUserId();		
		
		if( $userId ) {		
		    $lease = new Unit_Model_Lease();
		    $db = $lease->getDbTable()->getAdapter();		   		
		
		    $query = $db->select()
		         ->from( array('L'=>'lease') )
			 ->join( array('T'=>'tenant'),'T.leaseId=L.id',array())
		         ->where( 'T.userId=?', $userId )		        
		         ->where( 'lastDay>=NOW()')
		         ->where( 'isCancelled=0')
		         ->order( 'leaseStartDate DESC' );   	   					
		    
		    $resultSet = $db->query($query);						
		    $container = null;				   
		    
		    if( $resultSet ) {	    
		        foreach ($resultSet as $row) {		           	
		            $container[] = $row;
		        }		        
		    }
		    return $container;
		}
		else {
			$this->setMessageState('errorFetchingCurrentUser');
			return false;
		}
	}
	
	/**
	 *  Fetches the current user's lease history
	 */
	public function fetchMyLeaseHistory(){
		$userId = User_Library_Helper_Utils::currentUserId();		
		
		if( $userId ) {		
		    $lease = new Unit_Model_Lease();
		    $db = $lease->getDbTable()->getAdapter();
		    
		    $query = $db->select()
		             ->from( array('L'=>'lease') )
			     ->join( array('T'=>'tenant'),'T.leaseId=L.id',array())
		             ->where( 'T.userId=?', $userId )
		             ->where( 'lastDay<NOW() OR isCancelled=1' )
		             ->order( 'leaseStartDate DESC' );		    	 
					
		    $resultSet = $db->query($query);						
		    $container = null;				   
		    
		    if( $resultSet ) {	    
		        foreach ($resultSet as $row) {		            
		            $container[] = $row;
		        }		        
		    }
		    return $container;
		}
		else {
			$this->setMessageState('errorFetchingCurrentUser');
			return false;
		}
	}
	
	/**
	 *  Verify that the unitId is assigned to the logged in tenant in a current or past lease
	 */
	public function verifyMyUnit( $unitId ) {
		if( !$unitId ){
			$this->setMessageState('missingUnitId');
			return false;
		}
		
		$userId = User_Library_Helper_Utils::currentUserId();			
				
		if( $userId ) {		
		    $lease = new Unit_Model_Tenant();
		    $db = $lease->getDbTable()->getAdapter();
		    
		    $query = $db->select()
		             ->from( array('L'=>'lease') )
			     ->join( array('T'=>'tenant'),'T.leaseId=L.id',array())
		             ->where( 'T.userId=?', $userId )
		             ->where( 'L.unitId=?', $unitId );		             					
		   
		    $resultSet = $db->fetchAll($query);
		    
		    if( $resultSet ){
			return true;
		    }
		    else {
			return false;
		    }		    
		}
		else {
			$this->setMessageState('errorFetchingCurrentUser');
			return false;
		}
	}
	
	/**
	 *  Verify that the selected lease belongs the logged in tenant in a current or past lease
	 */
	public function verifyMyLease( $leaseId ) {
		if( !$leaseId ){
			$this->setMessageState('missingLeaseId');
			return false;
		}
		
		$userId = User_Library_Helper_Utils::currentUserId();			
				
		if( $userId ) {		
		    $lease = new Unit_Model_Tenant();
		    $db = $lease->getDbTable()->getAdapter();
		    
		    $query = $db->select()
		             ->from( array('L'=>'lease') )
			     ->join( array('T'=>'tenant'),'T.leaseId=L.id',array())
		             ->where( 'T.userId=?', $userId )
		             ->where( 'L.id=?', $leaseId );		             					
		   
		    $resultSet = $db->fetchAll($query);
		    
		    if( $resultSet ){
			return true;
		    }
		    else {
			return false;
		    }		    
		}
		else {
			$this->setMessageState('errorFetchingCurrentUser');
			return false;
		}
	}
	
	/**
	 *  Used on the view lease page
	 */
	public function getLeaseFees( $leaseId ) {
		if( !$leaseId ){
			$this->setMessageState('missingLeaseId');
			return false;
		}		
		
		$lease = new Unit_Model_Lease();
		$db = $lease->getDbTable()->getAdapter();
		
		$query = $db->select()
		         ->from( array('lf'=>'leaseFee'), array('amount'=>'lf.amount', 'billId'=>'lf.billId') )
		         ->join( array('b'=>'bill'),'lf.billId=b.id' )
		         ->join( array('f'=>'fee'),'lf.feeId=f.id',array('name'=>'f.name') )
		         ->where('lf.leaseId=?', $leaseId);

		$resultSet = $db->query( $query );
			
		$container = null;
		foreach ($resultSet as $row) {
		    $container[] = $row;
		}    

		return $container;	
	}
	
	/**
	 *  Looks at the lease bill tables to verify the current user can view only his bills
	 */
	public function verifyLeaseBill( $billId ) {   
	    if( !$billId ){
		$this->setMessageState('missingBillId');
		return false;
	    }		
		
	    $lease = new Unit_Model_Lease();
	    $db = $lease->getDbTable()->getAdapter();
	    
	    $billIdQuoted = $db->quote( $billId );	    
	    
	    $userId = User_Library_Helper_Utils::currentUserId();	
	    
	    if( $userId ) {		
	        //  Thank god that the children weren't onboard to see it
	        $query = "SELECT L.id
	              FROM leaseFee AS LF
		      JOIN lease AS L ON L.id = LF.leaseId
		      JOIN tenant AS T ON T.leaseId = L.id
		      WHERE T.userId = {$userId}
		      AND LF.billId = {$billIdQuoted}
		      UNION
		      SELECT L.id
	              FROM leaseSchedule AS LS
		      JOIN lease AS L ON L.id = LS.leaseId
		      JOIN tenant AS T ON T.leaseId = L.id
		      WHERE T.userId = {$userId}
		      AND LS.billId = {$billIdQuoted}";		     
                $resultSet = $db->fetchCol($query);
		//$resultSet = $db->fetchAll($query);		
		    
		if( $resultSet ){
		    //var_dump( $resultSet ); die;	
		    return $resultSet[0]; // return leaseId
		    //return true;
    		}
		else {
			return false;
		}
	     }	
	     else {
		$this->setMessageState('errorFetchingCurrentUser');
		return false;
	     }
	}
	
	/**
	 *  Fetch eviction documents for each lease	
	 */	
	public function fetchEvictionDocuments( $evictionId ){	
		
		if( empty($evictionId) ) {		    
			$this->setMessageState('evictionId');
			return false;
		}
		else {		   
		   $evictionFile = new Unit_Model_EvictionFile();
		   $db = $evictionFile->getDbTable()->getAdapter();		   
		   $src = $evictionFile->getSrc();
		
		   $select = $db->select()
		   ->from( array('F'=>'file'))			  
		   ->join( array('EF'=>'evictionFile'),'EF.fileId=F.id',array('evictionFileId'=>'EF.id','evictionId'=>'EF.evictionId'))
		   ->where('EF.evictionId=?',$evictionId,'int')
		   ->where('deleted=0');		   	   
					
		   $resultSet = $db->query($select);						
		   $container = null;		
		   		    
		   foreach ($resultSet as $row) {
		      $row['path'] = $this->formatPath( $src, $row['path'] );	
		      $container[] = $row;
		   }
		   return $container;
		}   
	}
}