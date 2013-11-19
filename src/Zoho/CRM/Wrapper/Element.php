<?php namespace Zoho\CRM\Wrapper;

abstract class Element
{
    /**
     * The deserialize method is called during xml parsing,
     * create an object of the xml received based on the entity
     * called
     *
     * @param string $xmlstr XML string to convert on object
     * @throws Exception If xml data could not be parsed
     * @return boolean
     */
    final public function deserializeXml($xmlstr) 
    {
    	try
    	{
			$element = new \SimpleXMLElement($xmlstr);		
    	} catch(\Exception $ex)
    	{
    		return false;
    	} foreach($element as $name => $value)
			$this->$name = $value;
		return true;
    }
    // final public function serializeXml() 
    // {}
}