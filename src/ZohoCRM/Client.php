<?php

namespace ZohoCRM;

/**
 * Zoho CRM API wrapper.
 */
class Client
{
  const BASE_URI = 'https://crm.zoho.com/crm/private';

  protected $authtoken;
  protected $client;
  protected $factory;
  protected $format;
  protected $module;

  public function __construct($authtoken, HttpClientInterface $client = null, FactoryInterface $factory = null)
  {
    $this->authtoken = $authtoken;
    // Only XML format is supported for the time being
    $this->format = 'xml';
    
    $this->client = $client ?: new HttpClient();
    $this->factory = $factory ?: new Factory();
  }

  /**
   * Implements convertLead API method.
   *
   * @param string $leadId  Id of the lead
   * @param array $data     xmlData represented as an array
   *                        array will be converted into XML before sending the request
   * @param array $params   request parameters
   *                        newFormat 1 (default) - exclude fields with null values in the response
   *                                  2 - include fields with null values in the response
   *                        version   1 (default) - use earlier API implementation
   *                                  2 - use latest API implementation
   *
   * @return Response The Response object
   */  
  public function convertLead($leadId, $data, $params = array())
  {
    $params['leadId'] = $leadId;
    return $this->call('convertLead', $params, $data);
  }

  /**
   * Implements getCVRecords API method.
   *
   * @param string $name    name of the Custom View
   * @param array  $params  request parameters
   *                        selectColumns     String  Module(optional columns) i.e, leads(Last Name,Website,Email) OR All
   *                        fromIndex         Integer Default value 1
   *                        toIndex           Integer Default value 20
   *                                                  Maximum value 200
   *                        lastModifiedTime  DateTime  Default value: null
   *                                                    If you specify the time, modified data will be fetched after the configured time.
   *                        newFormat         Integer 1 (default) - exclude fields with null values in the response
   *                                                  2 - include fields with null values in the response
   *                        version           Integer 1 (default) - use earlier API implementation
   *                                                  2 - use latest API implementation
   *
   * @return Response The Response object
   */
  public function getCVRecords($name, $params = array())
  {
    $params['cvName'] = $name;
    return $this->call('getCVRecords', $params);
  }

  /**
   * Implements getFields API method.
   *
   * @return Response The Response object
   */
  public function getFields()
  {
    return $this->call('getFields', array());
  }

  /**
   * Implements deleteRecords API method.
   *
   * @param string $id      Id of the record
   *
   * @return Response The Response object
   */
  public function deleteRecords($id)
  {
    $params['id'] = $id;
    return $this->call('deleteRecords', $params);
  }

  /**
   * Implements getRecordById API method.
   *
   * @param string $id      Id of the record
   * @param array $params   request parameters
   *                        newFormat 1 (default) - exclude fields with null values in the response
   *                                  2 - include fields with null values in the response
   *                        version   1 (default) - use earlier API implementation
   *                                  2 - use latest API implementation
   *
   * @return Response The Response object
   */
  public function getRecordById($id, $params = array())
  {
    $params['id'] = $id;
    return $this->call('getRecordById', $params);
  }

  /**
   * Implements getRecords API method.
   *
   * @param array $params   request parameters
   *                        selectColumns     String  Module(optional columns) i.e, leads(Last Name,Website,Email) OR All
   *                        fromIndex	        Integer	Default value 1
   *                        toIndex	          Integer	Default value 20
   *                                                  Maximum value 200
   *                        sortColumnString	String	If you use the sortColumnString parameter, by default data is sorted in ascending order.
   *                        sortOrderString	  String	Default value - asc
   *                                          if you want to sort in descending order, then you have to pass sortOrderString=desc.
   *                        lastModifiedTime	DateTime	Default value: null
   *                                          If you specify the time, modified data will be fetched after the configured time.
   *                        newFormat         Integer	1 (default) - exclude fields with null values in the response
   *                                                  2 - include fields with null values in the response
   *                        version           Integer	1 (default) - use earlier API implementation
   *                                                  2 - use latest API implementation
   *
   * @return Response The Response object
   */  
  public function getRecords($params = array())
  {
    return $this->call('getRecords', $params);
  }

  /**
   * Implements getSearchRecords API method.
   *
   * @param string $searchCondition search condition in the format (fieldName|condition|searchString)
   *                                e.g. (Email|contains|*@sample.com*)
   * @param array $params           request parameters
   *                                selectColumns String  Module(columns) e.g. Leads(Last Name,Website,Email)
   *                                                      Note: do not use any extra spaces when listing column names
   *                                fromIndex	    Integer	Default value 1
   *                                toIndex	      Integer	Default value 20
   *                                                      Maximum value 200
   *                                newFormat     Integer 1 (default) - exclude fields with null values in the response
   *                                                      2 - include fields with null values in the response
   *                                version       Integer 1 (default) - use earlier API implementation
   *                                                      2 - use latest API implementation
   *
   * @return Response The Response object
   */
  public function getSearchRecords($searchCondition, $params = array())
  {
    $params['searchCondition'] = $searchCondition;
    if(empty($params['selectColumns'])) {
      $params['selectColumns'] = 'All';
    }
    
    return $this->call('getSearchRecords', $params);
  }

  /**
   * Implements getSearchRecordsByPDC API method.
   *
   * @param string $searchColumn    search column
   *                                e.g. Email or First Name
   * @param string $searchValue     search value
   *                                e.g. John
   * @param array $params           request parameters
   *                                selectColumns String  Module(columns) e.g. Leads(Last Name,Website,Email)
   *                                                      Note: do not use any extra spaces when listing column names
   *                                newFormat     Integer 1 (default) - exclude fields with null values in the response
   *                                                      2 - include fields with null values in the response
   *                                version       Integer 1 (default) - use earlier API implementation
   *                                                      2 - use latest API implementation
   *
   * @return Response The Response object
   */
  public function getSearchRecordsByPDC($searchColumn, $searchValue, $params = array())
  {
    $params['searchColumn'] = $searchColumn;
    $params['searchValue'] = $searchValue;
    if(empty($params['selectColumns'])) {
      $params['selectColumns'] = 'All';
    }
    
    return $this->call('getSearchRecordsByPDC', $params);
  }
  
  /**
   * Implements getUsers API method.
   *
   * @param string  $type       type of the user to return. Possible values:
   *                              AllUsers - all users (both active and inactive)
   *                              ActiveUsers - only active users
   *                              DeactiveUsers - only deactivated users
   *                              AdminUsers - all users with admin privileges
   *                              ActiveConfirmedAdmins - users with admin privileges that are confirmed
   * @param integer $newFormat  1 (default) - exclude fields with null values in the response
   *                            2 - include fields with null values in the response
   *
   * @return Response The Response object
   */
  public function getUsers($type = 'AllUsers', $newFormat = 1)
  {
    $params['type'] = $type;
    $params['newFormat'] = $newFormat;

    return $this->call('getUsers', $params);
  }

  /**
   * Implements insertRecords API method.
   *
   * @param array $data     xmlData represented as an array
   *                        array will be converted into XML before sending the request
   * @param array $params   request parameters
   *                        wfTrigger	      Boolean	Set value as true to trigger the workflow rule
   *                                          while inserting record into CRM account. By default, this parameter is false.
   *                        duplicateCheck	Integer	Set value as "1" to check the duplicate records and throw an
   *                                                error response or "2" to check the duplicate records, if exists, update the same.
   *                        isApproval	    Boolean	By default, records are inserted directly . To keep the records in approval mode,
   *                                                set value as true. You can use this parameters for Leads, Contacts, and Cases module.
   *                        newFormat       Integer	1 (default) - exclude fields with null values in the response
   *                                                2 - include fields with null values in the response
   *                        version         Integer	1 (default) - use earlier API implementation
   *                                                2 - use latest API implementation
   *                                                4 - enable duplicate check functionality for multiple records.
   *                                                It's recommended to use version 4 for inserting multiple records
   *                                                even when duplicate check is turned off.
   *
   * @return Response The Response object
   */ 
  public function insertRecords($data, $params = array())
  {
    if (!isset($params['duplicateCheck'])) {
      // @todo: make default value for duplicateCheck configurable
      $params['duplicateCheck'] = 1;
    }
    if (!isset($params['version']) && count($data['records']) > 1) {
      $params['version'] = 4;
    }
    
    return $this->call('insertRecords', $params, $data);
  }

  /**
   * Implements updateRecords API method.
   *
   * @param string $id       ID of the record to be updated.
   *                         Set it to NULL when updating multiple records.
   * @param array  $data     xmlData represented as an array
   *                         array will be converted into XML before sending the request
   * @param array  $params   request parameters
   *                         wfTrigger    Boolean   Set value as true to trigger the workflow rule
   *                                                while inserting record into CRM account. By default, this parameter is false.
   *                         newFormat    Integer   1 (default) - exclude fields with "null" values while updating data
   *                                                2 - include fields with "null" values while updating data
   *                         version      Integer   1 (default) - use earlier API implementation
   *                                                2 - use latest API implementation
   *                                                4 - update multiple records in a single API method call
   *
   * @return Response The Response object
   */
  public function updateRecords($id, $data, $params = array())
  {
    if (empty($id) || count($data['records']) > 1) {
      // Version 4 is mandatory for updating multiple records.
      $params['version'] = 4;
    }

    if (!isset($params['version']) || $params['version'] != 4) {
      if (empty($id)) {
        throw new \InvalidArgumentException('Record Id is required and cannot be empty.');
      }
      $params['id'] = $id;
    }

    return $this->call('updateRecords', $params, $data);
  }

  /**
   * Implements getRelatedRecords API method.
   *
   * @param string $id              Id of the record for which to fetch related records.
   * @param string $parentModule    Name of the Zoho Module for which to fetch related records.
   *                                Example: If you want to fetch Leads related to a Campaign,
   *                                         then Campaigns is a parent module.
   * @param array $params           request parameters
   *                                fromIndex     Integer Default value 1
   *                                toIndex       Integer Default value 20
   *                                                      Maximum value 200
   *                                newFormat     Integer 1 - exclude fields with null values from the response (default)
   *                                                      2 - include fields with null values in the response
   *
   * @return Response The Response object
   */
  public function getRelatedRecords($id, $parentModule, $params = array())
  {
    $params['id'] = $id;
    $params['parentModule'] = $parentModule;

    return $this->call('getRelatedRecords', $params);
  }

  public function getModule()
  {
    return $this->module;
  }
  
  public function setModule($module)
  {
    $this->module = $module;
  }



  protected function call($command, $params, $data = array())
  {
    $uri = $this->getRequestURI($command);
    $body = $this->getRequestBody($params, $data);

    $xml = $this->client->post($uri, $body);
    return $this->factory->createResponse($xml, $this->module, $command);
  }

  protected function getRequestURI($command)
  {
    if (empty($this->module)) {
      throw new \RuntimeException('Zoho CRM module is not set.');
    }

    $parts = array(self::BASE_URI, $this->format, $this->module, $command);
    return implode('/', $parts);
  }

  protected function getRequestBody($params, $data)
  {
    $params['scope'] = 'crmapi';
    $params['authtoken'] = $this->authtoken;
    $params += array(
      'newFormat' => 1,
      //'version' => 2,
    );

    if (!empty($data)) {
      $params['xmlData'] = $this->toXML($data);
    }

    return http_build_query($params, '', '&');
  }

  protected function toXML($data)
  {
    
    $root = isset($data['root']) ? $data['root'] : $this->module;

    $no = 1;
    $xml = '<'. $root .'>';
    
    if (isset($data['options'])) {
      $xml .= '<row no="'. $no .'">';
      foreach ($data['options'] as $key => $value) {
        $xml .= '<option val="'. $key .'">'. $value .'</option>';
      }
      $xml .= '</row>';
      $no++;
    }
    
    foreach ($data['records'] as $row) {
      $xml .= '<row no="'. $no .'">';
      foreach ($row as $key => $value) {
        if (is_array($value)) {
          $xml .= '<FL val="'. $key .'">';
          foreach ($value as $k => $v) {
            list($tag, $attribute) = explode(' ', $k);
            $xml .= '<'. $tag .' no="'. $attribute .'">';
            foreach ($v as $kk => $vv) {
              $xml .= '<FL val="'. $kk .'"><![CDATA['. $vv .']]></FL>';
            }
            $xml .= '</'. $tag .'>';
          }
          $xml .= '</FL>';
        }
        else {
          $xml .= '<FL val="'. $key .'"><![CDATA['. $value .']]></FL>';
        }
      }
      $xml .= '</row>';
      $no++;
    }
    $xml .= '</'. $root .'>';

    return $xml;
  }  

}
