<?php

namespace ZohoCRM;

interface HttpClientInterface
{
  
  /**
   * Performs POST request.
   *
   */
  function post($uri, $postBody);

}
