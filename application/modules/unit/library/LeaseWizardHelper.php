<?php
/**
 * Helper for Lease Wizard
 */

class Unit_Library_LeaseWizardHelper implements ZFInterfaces_Messageable{				
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
	 *  Fetch prelease fees for each user
	 *  Used in the prelease fee page of lease wizard	
	 */	
	public function fetchPreleaseFee( $users=array(), $unitId ){					
		if( empty($users) ) {		    
			$this->setMessageState('noUsers');
			return false;
		}
		else {
		   $prelease = new Applicant_Model_Prelease();
		   return $prelease->fetchPreleaseFeeByUser( $users, $unitId );
		}   	
	}
	
	/**
	 *  Fetch lease fees for each lease
	 *  Used in the lease fee page of lease wizard	
	 */	
	public function fetchLeaseFee( $leaseId ){					
		if( empty($leaseId) ) {		    
			$this->setMessageState('missingLeaseId');
			return false;
		}
		else {		   
		   $fee = new Financial_Model_Fee();
		   $db = $fee->getDbTable()->getAdapter();
		
		   $select = $db->select()
		   ->from( array('F'=>'fee'),array('feeName'=>'F.name'))		
		   ->join( array('LF'=>'leaseFee'),'LF.feeId=F.id',array('leaseFeeId'=>'LF.id', 'amount'=>'LF.amount','feeId'=>'LF.feeId','billId'=>'LF.billId'))
		   ->join( array('L'=>'lease'),'LF.leaseId=L.id',array())		   
		   ->where('L.id=?',$leaseId,'int')
		   ->group( array('feeName','leaseFeeId','amount') );		   					
					
		   $resultSet = $db->query($select);						
		   $container = null;		
		   		    
		   foreach ($resultSet as $row) {
		      $container[$row['leaseFeeId']] = $row;
		   }
		   return $container;
		}   
	}
	
	/**
	 *  Save prelease fees 
	 */
	public function saveSelectedPreleaseFees( $leaseWizardItem, $fees, $selectedFees ) {		
		$finalArray = array();
		$return=true;
		if( $fees && $selectedFees ) {
		    foreach( $selectedFees as $index=>$key ) {			
			$finalArray[$key] = $fees[$key];
		    }
		    $leaseWizardItem->setPreleaseFee($finalArray);
		    $return = $leaseWizardItem->save();		    
		}
		return $return;
	}
	
	/**
	 *  Save lease fees 
	 */
	public function saveSelectedLeaseFees( $leaseWizardItem, $fees, $selectedFees ) {		
		$finalArray = array();
		$return=true;
		if( $fees && $selectedFees ) {
		    foreach( $selectedFees as $index=>$key ) {			
			$finalArray[$key] = $fees[$key];
		    }
		    $leaseWizardItem->setLeaseFee($finalArray);
		    $return = $leaseWizardItem->save();		    
		}
		return $return;
	}
	
	
	/**
	 *  Clone leaseWizard row - used for lease renewal
	 */
	public function cloneRow( $leaseId ) {		
		$fee = new Financial_Model_Fee();
		$db = $fee->getDbTable()->getAdapter();
		
		// verify leaseId exists in leaseWizard
		$leaseWizard = new Unit_Model_LeaseWizard( array( 'db'=>$db) );
		$item = $leaseWizard->findByKey( array( 'search'=>array('leaseId'=>$leaseId))); // doesn't filter on user because maybe the creator of the lease is no longer around		    		    		   
		    
		if( $item ){
		    $leaseRow = array_shift($item);		    
		    if( $leaseRow->getUnitId() ) {
		        try{
			    $db->beginTransaction();	
			    // remove any unfinished rows
			    $leaseRow->setDbAdapter( $db );	
			    $rows = $leaseRow->getUnfinishedRow( $leaseRow->getUnitId() );
			    
			    if( $rows ) {
				foreach( $rows as $id=>$row ) {
			    	$leaseWizard->delete( $row['id'] );
				}
			    }
			    // set items for new leaseWizard clone	  
			    $leaseRow->setId(null);
			    $leaseRow->setDateUpdated(null);
			    $leaseRow->setLeaseId(null);
			    $leaseRow->setFee(null);  // unset any new fees
			    $leaseRow->setFromLeaseId($leaseId);
			    $leaseRow->setUserId(User_Library_Helper_Utils::currentUserId());			    
			    $cloned = $leaseRow->save();
			    
			    $db->commit();
			    return $leaseRow->getUnitId();
			}
			catch(Exception $e) {
			    $db->rollBack();
			    echo $e->getMessage();			
			    return false;
			}
		    }
		}    
	}	
}