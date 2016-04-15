<?php

namespace Doppy\ShortcodeBundle\Exception;

/**
 * Class InvalidProcessorException
 * 
 * Thrown when a Processor is requested that is configured, but appears not to be in the service container
 */
class InvalidProcessorException extends \RuntimeException implements ExceptionInterface {

}