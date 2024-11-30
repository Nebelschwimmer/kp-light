<?php
namespace  App\Exception\NotFound;
class ActorNotFoundException extends \RuntimeException
{
  public function __construct()
  {
    parent::__construct('Actor not found');
  }

}