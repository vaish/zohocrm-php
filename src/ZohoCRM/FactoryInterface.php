<?php

namespace ZohoCRM;

interface FactoryInterface
{
  
  /**
   * Creates Response object
   *
   */
  function createResponse($xml, $module, $method);
  
}
