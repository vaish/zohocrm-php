<?php

namespace ZohoCRM;

class Factory implements FactoryInterface
{
  public function createResponse($xml, $module, $method)
  {
    return new Response($xml, $module, $method);
  }
}
