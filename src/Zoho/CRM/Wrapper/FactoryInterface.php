<?php namespace Zoho\CRM\Response;

/**
 * Common interface for response creators
 *
 * @version 1.0.0
 */
interface FactoryInterface
{
  /**
   * Creates Response object
   *
   * @param string $xml XML for create a response
   * @param string $module Module used
   * @param string $method Method used on request to ws
   */
  public function createResponse($xml, $module, $method);
}
