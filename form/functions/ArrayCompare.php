<?php
/** 
* Give the object 2 arrays when you create it.
*
* Then you can then use the compare method or invoke to ask for a specific key.
*
* If the key is in the first array its value will be returned.
*
* If the key is not in the first array but they key is in the 2nd array,
* the vaue from the 2nd array will be returned.
* 
* This is useful when you have a form that shows data from the database but also shows
* the POSTed value of a field when the form is re-displayed after a validation error.
*
* But you will not always want to compare against $_POST, sometimes you want to compare 
* against $_GET or some other arbitrarily named array.
* 
* The limitation of this class is that the desired key must be the same in both arrays.
*
* If you want to use it with a form that does not involve a database, 
* only pass 1 array (like $_POST).
* 
* @todo add a $map1 & $map2 that are arrays that show how a requested key should be
* renamed before you go looking for it in one of the source arrays.
* This will allow comparison between arrays where the keys aren't named the same.
* Or this could be done by making another method that takes 2 keys as arguments.
* Example: $AC->compKeys( 'description', 'body', 'default value if both keys blank');
* 2018-02-11
* @author thinsoldier@thinsoldier.com
*/
class ArrayCompare
{
	/**  @var array $one The first array to compare against	 */
	public $one = null;
	
	/** @var array $two The second array to compare against */
	public $two = null;	

	/**
	 * Initialize object and provide 1 or 2 source arrays
	 * Usually the first one is POST and the 2nd one is database data.
	 * @param array $source1
	 * @param array $source2
	 */
	public function __construct($source1, $source2=array())
	{
			$this->one = $source1;
			$this->two = $source2;
	}
	
	/**
	 * Look in both source arrays and return the value of the given key
	 *
	 * @param str $key Entry in array you want the value of to be returned
	 * @param str $if_not_found Value to return if not found in either array
	 * @return unknown The value found or given fallback value;
	 */
	public function comp($key, $if_not_found = false)
	{
		if(isset($this->one["$key"])) 
		{ $to_return = $this->one["$key"]; } // if found, give back it's value
		elseif(isset($this->two[$key])) 
		{ $to_return = $this->two[$key]; } // if NOT found, give the alternative
		else { $to_return = $if_not_found; } // if STILL not found, give the last resort value
		
		if( is_string($to_return) )
		{ $to_return = htmlspecialchars($to_return, ENT_QUOTES, "UTF-8"); }
		
		return $to_return;
	}
	
	/**
	 * Just a wrapper for ArrayCompare::comp
	 * Allows invoking the object itself.
	 * $AC('email') instead of $AC->comp('email')
	 * 
	 * @see ArrayCompare::comp()
	 * @param unknown_type $key
	 * @param unknown_type $if_not_found
	 * @return unknown the results of comp()
	 */
	public function __invoke($key, $if_not_found = false)
	{
		return $this->comp($key, $if_not_found);
	}
	
}
