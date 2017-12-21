<?php
namespace AppBundle\Command;

use AppBundle\Utils\Utils;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class RssCommand extends ContainerAwareCommand
{

    use Utils;

    /**
     * Object writing log
     *
     * @var object
     */
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
        ->addArgument('urls', InputArgument::REQUIRED, 'The feed urls need to get item data');
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

        $output->writeln('Processing data...');

        $this->logger->debug('Using command function', [
            'category'   => 'AppBundle.Command.RssCommand.execute',
            'parameters' => $input->getArguments()
        ]);

        $objFeed = $this->getContainer()->get('GetFeed');
        $urls        = $this->filterURL($input->getArgument('urls'));
        $mgs         = '<info>Congratulation, get data successfully!</>';

        if (empty($urls)) {
            $mgs = '<comment>Please input an valid URL!</>';
        } else if (!$objFeed->getDataFromURL($urls)) {
            $mgs = '<error>Get data failed, please try it again!</>';
        }

        $output->writeln([
            "<info>------------------------------------------------------------------</>",
            $mgs,
            '<info>------------------------------------------------------------------</>',
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

}
