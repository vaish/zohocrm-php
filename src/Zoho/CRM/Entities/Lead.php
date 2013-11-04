<?php namespace Zoho\CRM\Entities;

use Sabre\XML;

/**
 * Entity for leads inside Zoho
 * This class only have default parameters
 *
 * @version 1.0.0
 */
class Lead implements XML\Element
{
	/**
	 * Zoho CRM user to whom the Lead is assigned.
	 * 
	 * @var string
	 */
	private $leadOwner;

	/**
	 * Salutation for the lead
	 * 
	 * @var string
	 */
	private $salutation;

	/**
	 * First name of the lead
	 * 
	 * @var string
	 */
	private $firstName;

	/**
	 * The job position of the lead
	 * 
	 * @var string
	 */
	private $title;

	/**
	 * Last name of the lead
	 * 
	 * @var string
	 */	
	private $lastName;

	/**
	 * Name of the company where the lead is working. 
	 * This field is a mandatory
	 * 
	 * @var string
	 */
	private $company;

	/**
	 * Source of the lead, that is, from where the lead is generated
	 * 
	 * @var string
	 */
	private $leadSouce;

	/**
	 * Industry to which the lead belongs
	 * 
	 * @var string
	 */
	private $industry;

	/**
	 * Annual revenue of the company where the lead is working
	 * 
	 * @var integer
	 */
	private $annualRevenue;

	/**
	 * Phone number of the lead
	 * 
	 * @var string
	 */
	private $phone;

	/**
	 * Modile number of the lead
	 * 
	 * @var string
	 */	
	private $mobile;

	/**
	 * Fax number of the lead
	 * 
	 * @var string
	 */	
	private $fax;

	/**
	 * Email address of the lead
	 * 
	 * @var string
	 */	
	private $email;


	/**
	 * Secundary email address of the lead
	 * 
	 * @var string
	 */	
	private $emailSecundary;

	/**
	 * Skype ID of the lead. Currently skype ID 
	 * can be in the range of 6 to 32 characters
	 * 
	 * @var string
	 */
	private $skypeId;

	/**
	 * Web site of the lead
	 * 
	 * @var string
	 */
	private $website;

	/**
	 * Status of the lead
	 * 
	 * @var string
	 */
	private $leadStatus;

	/**
	 * Rating of the lead
	 * 
	 * @var string
	 */
	private $rating;

	/**
	 * Number of employees in lead's company
	 * 
	 * @var integer
	 */
	private $noEmployees;

	/**
	 * Remove leads from your mailing list so that they will 
	 * not receive any emails from your Zoho CRM account
	 * 
	 * @var string
	 */
	private $emailOpt;

	/**
	 * Campaign related to the Lead
	 * 
	 * @var string
	 */
	private $campaingSource;

	/**
	 * Street address of the lead
	 * 
	 * @var string
	 */
	private $street;

	/**
	 * Name of the city where the lead lives
	 * 
	 * @var string
	 */
	private $city;

	/**
	 * Name of the state where the lead lives
	 * 
	 * @var string
	 */
	private $state;

	/**
	 * Postal code of the lead's address
	 * 
	 * @var string
	 */
	private $zipCode;

	/**
	 * Name of the lead's country
	 * 
	 * @var string
	 */
	private $country;

	/**
	 * Other details about the lead
	 * 
	 * @var string
	 */
	private $description;

	/**
	 * Getter
	 * 
	 * @return mixed
	 */
	public function __get($property)
	{
		return isset($this->$property)?$this->$property :null;
	}

	/**
	 * Setter
	 *
	 * @param string $property Name of the property to set the value
	 * @param mixed $value Value for the property
	 * @return mixed
	 */
	public function __set($property, $value)
	{
		$this->$property = $value;
		return $this->$property;
	}

    /**
     * The serialize method is called during xml writing.
     *
     * It should use the $writer argument to encode this object into XML.
     *
     * Important note: it is not needed to create the parent element. The
     * parent element is already created, and we only have to worry about
     * attributes, child elements and text (if any).
     *
     * @param XML\Writer $reader
     * @return void
     */
    public function serializeXml(XML\Writer $writer) 
    {
        $writer->writeAttribute('href', $this->href);
        $writer->writeAttribute('rel', $this->rel);
        $writer->writeAttribute('type', $this->type);
    }

    /**
     * The deserialize method is called during xml parsing.
     *
     * This method is called statictly, this is because in theory this method
     * may be used as a type of constructor, or factory method.
     *
     * Often you want to return an instance of the current class, but you are
     * free to return other data as well.
     *
     * @param XML\Reader $reader
     * @return mixed
     */
    static public function deserializeXml(XML\Reader $reader) 
    {
        $attributes = $reader->parseAttributes();
        $link = new self();
        foreach($attributes as $name=>$value) {
            if (property_exists($link,$name)) {
                $link->$name = $value;
            }
        }
        $reader->next();
        return $link;
    }	
}