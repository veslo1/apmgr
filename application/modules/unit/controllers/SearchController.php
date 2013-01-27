<?php
/**
 * Controller form to allow the user to search for units
 *
 * @author Jorge Vazquez <jvazquez@debserverp4.com.ar>
 */
class Unit_SearchController extends ZFController_Controller
{
	/**
	 * Main action
	 */
	public function indexAction()
	{
		$searchForm = new Unit_Form_SearchUnitFrontend();
		$searchForm->setForm();
		$unit = new Unit_Library_SearchHelper();
                
        //  There's no is valid,because there's no text area to validate
		$request = $this->getRequest()->getParams();
		$unit = new Unit_Library_SearchHelper($request);
		//  There's no is valid,because there's no text area to validate
		if( $this->getRequest()->isPost() )
		{
			$searchForm->populate($this->getRequest()->getParams());
			$result = $searchForm->persistData();
		}
		$searchForm->populate($searchForm->getPersistedData());
		$result = $unit->searchUnit($searchForm->getPersistedData());
		$this->view->units = $this->paginate($result);
		$this->view->form = $searchForm;
	}
}
?>
