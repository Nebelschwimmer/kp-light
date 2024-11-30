<?php
namespace  App\Exception\Unique;

class DirectorIsActorException extends \Exception {
  public function __construct() {
    parent::__construct('Director is an actor');
  }
}