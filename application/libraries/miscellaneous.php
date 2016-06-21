<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Miscellaneous {


	public function __contruct()
	{
		parent::__contruct();
	}
	
	public function decodeURL($values)
	{
		$fields;
		$a = explode('&', $values);
		$i = 0;
		while ($i < count($a)) {
			$b = explode ('=', $a[$i]);
			$fields[htmlspecialchars(urldecode($b[0]))] = htmlspecialchars(urldecode($b[1]));
			$i++;
		}
		return $fields;
	}
	
	public function printMENU($uri, $type='', $flag = '' )
	{
		$vuelta = 1;
		$xml = ($type=='be_menu') ?
			simplexml_load_file(base_url().'resources/xml/menu_sistema.xml') :
			simplexml_load_file(base_url().'resources/xml/menu.xml');
		$secc = ($type=='be_menu') ? 'sistema/' : '';
		$response = '';
		$submenu = '';
		$class = '';
		$class2= '';
		$title = '';
		$href = '';
		$attr = '';
		$show = '';
		foreach($xml->children() as $child)
		{
			$submenu = '';
			if(isset($child->child)){
				$tmp = $child->child;
				$attr = $tmp->attributes();
				$show = $attr->show;
				if( $show[0] == $flag )
				{
					foreach($tmp->children() as $row){
						$title = ucfirst($row->title);
						$href = base_url().$secc.$child->href."/".$row->href;
						$li_id = isset($child->li_id) ? $row->li_id : '';
						$submenu .= "<li id=\"".$li_id."\"><a href=\"".$href."\" title=\"".$title."\"><span>".$title."</span></a></li>";
					}
					if(!empty($submenu)) $submenu = "<ul>".$submenu."</ul>";
				}
			}
			$li_id = isset($child->li_id) ? $child->li_id : '';
			$title = ucfirst($child->title);
			
			if($type=='be_menu'){
				$href = base_url()."sistema/".$child->href;
			}
			else{
				$href = base_url().$child->href;
			}
			
			$class = $child->href == $uri ? 'active' : $child->href;
			if($vuelta<= 1 ){
				$class.=' first';
			}
			$class2= $child->class2;
			if($child->href == $uri){ $class.=" $child->href";}
		
			$response .= "
				<li id=\"".$li_id."\" class=\"".$class." ".$class2."\">
					<a href=\"".$href."\" title=\"".$title."\">".$title."</a>
					".$submenu."
				</li>";	
		
		$vuelta++;	
		}
		if(!empty($response)) $response = "<ul>".$response."</ul>"; 
			return $response;
	}

}