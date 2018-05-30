<?php

namespace PR\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PRUserBundle extends Bundle
{
  public function getParent(){

    return 'FOSUserBundle';
  }
}
