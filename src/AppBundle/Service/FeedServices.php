<?php
namespace AppBundle\Service;

Use AppBundle\Entity\Feed;
use AppBundle\Api\RssApi;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;


class FeedServices
{
    protected $em;
    private $container;

    public function __construct(EntityManager $entityManager, Container $container)
    {
        $this->em = $entityManager;
        $this->container = $container;
    }
    
    /**
     * Send request and store data into DB
     *
     * @param  array     $urls the array urls
     * @return string    output message having type (info|comment|error)
     */
    public function getDataFromURL($urls)
    {

        // Get item data from API
        $apiRss = new RssApi();
        $apiRss->sendRequest($urls);
        $itemData = $apiRss->getItemData();
        if (empty($itemData)) {
           return false;
        }
        $batchSize = 100;
        foreach ($itemData as $key => $item) {
            $feed = new Feed();
            $feed->setTitle($item[$apiRss->titleKey]);
            $feed->setDescription($item[$apiRss->despKey]);
            $feed->setLink($item[$apiRss->linkKey]);
            $feed->setGuid($item[$apiRss->guidKey]);
            $feed->setPubDate($item[$apiRss->dateKey]);
            $feed->setCategory($item[$apiRss->categoryKey]);
            $feed->setComment($item[$apiRss->commentKey]);
            $this->em->persist($feed);
            if (($key % $batchSize) === 0) {
                $this->em->flush();
                $this->em->clear(); // Detaches all objects from Doctrine!
            }
        }
        $this->em->flush(); //Persist objects that did not make up an entire batch
        $this->em->clear();

        return true;
    }

}
