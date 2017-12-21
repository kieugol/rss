<?php
namespace AppBundle\Api;

use AppBundle\Api\AbstractApi;
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

    // Using abstract key instead of API key
    public $titleKey    = 'title';
    public $despKey     = 'desp';
    public $linkKey     = 'link';
    public $categoryKey = 'category';
    public $dateKey     = 'date';
    public $guidKey     = 'guid';
    public $commentKey  = 'comment';

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
                            "$this->titleKey"    => $result->title,
                            "$this->despKey"     => $result->description,
                            "$this->linkKey"     => $result->link,
                            "$this->guidKey"     => !empty($result->guid) ? $result->guid : '',
                            "$this->categoryKey" => !empty($result->category) ? $result->category : '',
                            "$this->commentKey"  => !empty($result->comments) ? $result->comments : '',
                            "$this->dateKey"     => new \Datetime($result->pubDate)
                        ];
                    }
                }
            }
        }
        return $datafilter;
    }
}
