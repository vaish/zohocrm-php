<?php namespace Zoho\CRM\Request;

use Zoho\CRM\Common\FactoryInterface;

/**
 * Interface for create response objects
 *
 * @implements FactoryInterface
 * @version 1.0.0
 */
class Factory implements FactoryInterface
{
  public function createResponse($xml, $module, $method)
  {
    return new Response($xml, $module, $method);
  }
}