<?php
/**
 *
 * @author Rachael Nelson <wtcfg1@gmail.com>
 * <p>Provide a description</p>
 *
 */
class Wulf_View_Helper_Testgrid extends Zend_View_Helper_Abstract {
	public $view = null;


	public function setView(Zend_View_Interface $view) {

		$this->view = $view;
		return $this;

	}

	/* this constructor takes 4 args, name of the grid, header columns, paginator and the bool value sorting. */

	// Needs some serious cleanup.  Maybe a function or 10
	public function testGrid ($name, $fields = null,$paginator=null,$sorting=false, $extra=null, $useObject=true) {
		// taking value of sort using Front controller getRequest() method.
		$sort = Zend_Controller_Front::getInstance()->getRequest()->getParam('sort','DESC');

		// checking and handling sorting.
		$sort = ( $sort == 'ASC' ) ? 'DESC' : "ASC" ;

		//var_dump($extra); die;

		// start constructing the grid.
		$output= "<div id='{$name}'>";

		// TODO:  not hard code this shit

		if ($paginator && $paginator->getPages()->pageCount>1 )
		$output.= $this->view->paginationControl($paginator,
                      'Sliding',
                      't3.phtml');


		$output .= "<table class='grid'>
                   	<thead>
           			<tr>";

		// this foreach loop display the column header  in "th" tag.
		if($paginator) {
			foreach ($fields as $key => $value)  {
				$output .= "<th>";

				$sub='';
				if ( strpos( $key, '.' ) )  {
					list( $key, $sub ) = explode( '.', $key );
					$key = strtolower($key) . ucfirst($sub);
				}

				// 	check if sorting is true, if so add link to the fields headers
				if ($sorting)
				$output .= "<a class=\"cleanlink\" href='".$this->view->url(array('sort'=>$sort,'by'=>$key))."'>".$value."</a>";
				else
				$output .= $value;

				$output .= "</th>";
			}

			$output .= "</tr></thead>";
		}

		// constructing the body that contain the records in rows and columns.
		$output .="<tbody>";

		// this loop displays the actual data.

		if ($paginator) {

			foreach($paginator as $p) {
				$output.="<tr>";

				// yeah this isn't that good but it works for now until we can come up with smtg better :)
				foreach($fields as $key=>$value) {
					$sub='';  // needed so the sub is reset for each field

					if ( strpos( $key, '.' ) )
					list( $key, $sub ) = explode( '.', $key );

					if( $useObject ){
						if ( !empty($sub) )  // if has sub object - this may  needed to be modified to be more generic if there are nested objects like $house->getRoom()->getFurniture()->getChair()
						$output .= "<td>". eval('return $p->get'.$key.'()->get'.$sub.'();' ) . "</td>";
						else
						$output .= "<td>". eval('return $p->get'.$key.'();') . "</td>";
					}
					else
					$output .= "<td> {$p[lcfirst($key)]}</td>";
				}

				if ( $extra ) {
					$output .= "<td>";

					$params=array();



					foreach( $extra as $name=>$data  )
					{
						$params = array( 'module'=>$data['module'],
										 'controller'=>$data['controller'],
										 'action'=>$data['action']
						);

						if( !isset($data['alias']) )
						$data['alias'] = strtolower($data['column']);

						// displays db columns

						if($useObject)
						$params[ $data['alias'] ] = eval('return $p->get'.$data['column'].'();');
						else
						$params[ $data['alias'] ] = $p[strtolower($data['column'])];




						// additional request params needed to pass in
						if( isset($data['requestparam'] ) )  {
							foreach ( $data['requestparam'] as $key=>$alias )
							$params[$alias] = Zend_Controller_Front::getInstance()->getRequest()->getParam( $key );
						}

						$output .= "<a href='{$this->view->url( $params )}'>";

						// Javascript callback code when clicking an image
						if ( $data['image'] )
						{
							$output .= "<img width='24' height='24' title='{$name}' alt='{$name}' src='/images/{$data['image']}'";

							//  did i win the obfuscated code contest yet?   No?  how bout the retard code with little error checking?  score!
							//  this does need to be better and not apply only to images, but will refactor this crap later when needed
							if( isset($data['js']) )
							{
								foreach( $data['js'] as $action=>$item )
								foreach ( $item as $callback => $par )
								{
									$vars = array_map( create_function( '$a', 'return Zend_Controller_Front::getInstance()->getRequest()->getParam($a);' ), $par );
									$output .= "{$action}='" . $callback . '(' . implode( ',', $vars ) . ")'";
								}
							}

							// add broken callback to link, if you want
							$output .= "/>";
						}
						else
						$output .= $name;

						$output .= "</a>&nbsp;";
					}

					$output .= "</td>";
				}

				$output.="</tr>";
			}
		}
		//  SHAME!! SHAME!!! Fix this!!
		else if($_POST)
		$output.= "<tr><td> No results found</td></tr>";

		$output .= "</tbody>";

		// check if paginator is true, if so then add paginator component to the table "tfoot".
		/*
		if ($paginator && $paginator->getPages()->pageCount > 1 ) {
		$output .="<tfoot>";
		$output .="<td align='center' colspan='".count($fields)."'>";

		$output.= $this->view->paginationControl($paginator,
		'Sliding',
		't3.phtml');

		$output .="</tfoot>";
		}
		*/

		$output .="</table></div>";

		return $output;
	}

}
?>
