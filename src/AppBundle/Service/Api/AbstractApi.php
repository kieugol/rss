<?php
namespace AppBundle\Service\Api;

use Guzzle\Http\Client;
use Guzzle\Common\Exception\MultiTransferException;
use Psr\Log\LoggerInterface;

abstract class AbstractApi 
{
    /**
     * Guzzle client object to send request
     *
     * @var null
     */
    protected $client = null;

    /**
     * The data response from API successfully
     *
     * @var object
     */
    protected $data = null;

    /**
     * The error message return from API
     * 
     * @var string
     */
    protected $errMgs = null;

    protected function _init($timeout = 4)
    {
        $this->client = new Client(['timeout' => $timeout]);
    }

    // Send API request and get response data
    abstract public function sendRequest($request);
    // Get all data response from API successfully
    abstract public function getData();
    // Get the string error message from API
    abstract public function getErrorMessage();
}
