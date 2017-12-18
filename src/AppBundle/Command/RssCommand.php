<?php
namespace AppBundle\Command;

Use AppBundle\Entity\Feed;
use AppBundle\Service\Api\RssApi;
use AppBundle\Utils\MysqlDB;
use AppBundle\Utils\Utils;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Psr\Log\LoggerInterface;

use Acme\MyDependency;

class RssCommand extends ContainerAwareCommand
{

    use Utils;

    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        parent::__construct();
    }

    /**
     * Configure app for console
     *
     * @return  void
     */
    protected function configure()
    {
        $this
        ->setName('grab-item')
        ->setDescription('Grab items from given urls')
        ->addArgument('urls', InputArgument::REQUIRED, 'The API urls need to get item data');
    }

    /**
     * Getting the URL from console, send request to get data and store into DB
     *
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Writing log command
        $this->logger->info('Using command function', [
            'category' => '8bit_trial.RssCommand.execute',
            'parameters' => $input->getArguments()
        ]);
        $urls = $this->filterURL($input->getArgument('urls'));
        if (empty($urls)) {
            $message = '<comment>Please input an valid URL!</>';
        }
        $message = $this->handleAPI($urls) ? '<info>Congratulation, get data successfully!</>'
                    : "<error>Get data failed, please try it again!</>";
        $output->writeln([
            "<info>==================================================================</>",
            $message,
            '<info>==================================================================</>',
        ]);
    }

    /**
     * Filtering URL valid
     *
     * @param  string  $url the string URL determined by the separator ","
     * @return array   the array contains valid URL
     */
    protected function filterURL($stringUrl)
    {
        $urls = explode(',', $stringUrl);
        foreach ($urls as $key => $val) {
            if (!$this->isUrl($val)) {
                unset($urls[$key]);
            }
        }
        return $urls;
    }

    /**
     * Handling send request and store data
     *
     * @param  array     $api the array API
     * @return boolean   true if the processing is successful else return false 
     */
    protected function handleAPI($api)
    {
        // Get item data from API
        $apiRss = new RssApi();
        $apiRss->sendRequest($api);
        $itemData = $apiRss->getItemData();
        if (empty($itemData)) {
            return false;
        }
        // Store data into DB
        $feedEntity  = new Feed();
        $mysql  = new MysqlDB(
            $this->getContainer()->getParameter('database_name'), 
            $this->getContainer()->getParameter('database_user'),
            $this->getContainer()->getParameter('database_password'),
            $this->getContainer()->getParameter('database_host')
        );
        return $mysql->insertMulti(
            $feedEntity->getTableName(),
            $feedEntity->getListColumnName(),
            $itemData
        );
    }
}