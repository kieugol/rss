<?php
namespace AppBundle\Service\Api;

use AppBundle\Service\Api\AbstractApi;
use Guzzle\Http\Client;
use Guzzle\Http\Exception\MultiTransferException;
use AppBundle\Utils\Utils;

class RssApi extends AbstractApi
{
    use Utils;

    public function __construct()
    {
        $this->_init();
    }

    /**
     * Send multiple requests parallel 
     *
     * @param  array $multiReqs  array API requests
     * @return void
     */
    public function sendRequest($reqs)
    {
        try {
            $multiReqs = [];
            foreach ($reqs as $url) {
                $multiReqs[] = $this->client->get($url);
            }
            $response = $this->client->send($multiReqs);
            foreach ($response as $resp) {
                if ($this->isXML($resp->getBody(true))) {
                    $this->data[] = $resp->xml();
                }
            }
        }  catch (MultiTransferException $e) {
            foreach ($e->getSuccessfulRequests() as $request) {
                if ($this->isXML($request->getResponse())) {
                    $this->data[] = $request->getResponse()->xml();
                }
            }
        }
    }

    /**
     * Get reponse data from API
     *
     * @return array [description]
     */
    public function getData()
    {
        return $this->data;
    }

    public function getErrorMessage() 
    {
        return $this->errMgs;
    }

    /**
     * Filtering item data from API response
     *
     * @return array  item data was filterd 
     */
    public function getItemData()
    {
        $datafilter = [];
        if (!empty($this->data)) {
            foreach ($this->data as $data) {
                if (!empty($data->channel->item)) {
                    foreach ($data->channel->item as $result) {
                        $datafilter[] = [
                            (string)$result->title,
                            (string)$result->description,
                            (string)$result->link,
                            !empty($result->guid) ? (string)$result->guid : '',
                            !empty($result->category) ? (string)$result->category : '',
                            !empty($result->comments) ? (string)$result->comments : '',
                            (string)(new \Datetime($result->pubDate))->format('Y-m-d H:i:s')
                        ];
                    }
                }
            }
        }
        return $datafilter;
    }
}
