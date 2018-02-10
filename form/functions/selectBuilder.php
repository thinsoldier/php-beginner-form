<?php
/**
 * Builds html select form fields.
 *
 * It will assume the array was NOT provided in the form of key=>value.
 *
 * You must specify the $key_or_nokey flag by using 'key' or 'nokey' when calling if you intend to have the $key of an array (usually a database ID field #) be used as the <option value="$key">$value</option>.
 * Otherwise it will default to using the value of the array as both the option value and visible text in the select box.
 *
 * <code><option value="$value">$value</option></code>
 *
 * EXAMPLE OF USAGE
 *
 * <code>
 * echo select_builder('day', range(1,32), POST_return('day', date("j")), 'nokey', '', 'Day');
 * echo select_builder('month', sb_months(), POST_return('month', date("m")), 'key', '', 'Month');
 * echo select_builder('year', range(1999,2016), POST_return('year', date("Y")), 'nokey', '', 'Year');
 * </code>
 *
 * @author thinsoldier@thinsoldier.com
 * @param string $name Name attribute of select tag
 * @param array $options flat or associative array of options
 * @param string $selected If the given value exists in the array of options it will have the selected attribute applied in its html tag
 * @param string $key_or_nokey Use the values 'key' or 'nokey'. Indicates whether or not the array keys of the options array will be utilized
 * @param string $extra Any other html attributes you want the select tag to have.
 * @param string $firstword Change what the first (valueless) option in the select says.
 * @return string HTML of select tag and its options
 */
function selectBuilder($name, $options, $selected, $key_or_nokey="nokey", $extra="", $firstword="Select" )
{	
	if($options !== ''){
	if(isset($_POST[$name])){$posted = $_POST[$name];}
		
	$content = "<select name=\"$name\" ";
	if($extra !='')	{ $content .= "$extra ";} // text insertions of style, id, class, whatever....
	$content .= ">\r\t";
	
	$content .= '<option value="">'.$firstword.'</option>'."\n";

	if(!empty($options) and is_array($options))
	{
		foreach($options as $key=>$opt)
		{	
			$opt=str_replace('&','&', stripslashes($opt));
			if($key_or_nokey === 'nokey')	{$k_o=$opt;}
			if($key_or_nokey === 'key')	{$k_o=$key;}
			if(!isset($posted) and $k_o == $selected){$isselected='selected="selected"';}else{$isselected='';}
			if(isset($posted) and $k_o == $posted) {$isselected='selected="selected"';}
			$content .= "\t<option value=\"$k_o\" $isselected>$opt</option>\r";
		}
	} else { //echo '<!-- select_builder() | $options was empty or not an array -->';
	}
	$content .= "</select>\r\r";
	return $content;
	
	}else{
		return '';
	}
}
