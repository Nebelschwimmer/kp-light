<?php
namespace  App\Exception\NotFound;
class DirectorNotFoundException extends \RuntimeException
{
  public function __construct()
  {
    parent::__construct('Director not found');
  }

}