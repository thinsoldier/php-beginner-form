<?php
/**
* Turns a multi-level array into a multi-level UL
* But it's not perfect
*/
function arrayToList ($array, $classes='', $id='' ) 
{ 
	if(empty($array)){return false;}
	
	$out = '<ul%s%s>';
	
	$id = (empty($id)) ? '' : " id=\"$id\"";
	$class = (empty($classes)) ? '' : ' class="'.$classes.'"';
	
	$out = sprintf($out, $id, $class);
	
	foreach ($array as $val) 
	{
		if (is_array($val)) { $val = arrayToList ($val); } 
		 $out .= '<li>' . $val . '</li>';
	}
	$out.='</ul>'; 
	return $out;
}
