<?php

namespace icicle\IcicleBundle\Command;

use Icicle\Http\Server\Server;
use icicle\IcicleBundle\Bridge\RequestListener;
use Icicle\Loop;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class IcicleRunCommand extends ContainerAwareCommand
{
    /**
     * @var RequestListener
     */
    public $requestListener;

    /**
     * IcicleServerCommand constructor.
     *
     * @param RequestListener $requestListener
     * @param string|null     $name            The name of the command; passing null means it must be set in configure()
     *
     * @throws \LogicException When the command name is empty
     */
    public function __construct(RequestListener $requestListener, string $name = null)
    {
        $this->requestListener = $requestListener;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('icicle:run');
        $this->setDescription('To create easily a ReactPHP Server with Symfony');
        $this->addOption(
            'interface',
            'i',
            InputOption::VALUE_OPTIONAL,
            'To set the TCP interface listened by ReactPHP',
            '0.0.0.0'
        );
        $this->addOption(
            'port',
            'p',
            InputOption::VALUE_OPTIONAL,
            'To set the TCP port listened by ReactPHP',
            '8000'
        );
    }



    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $server = new Server($this->requestListener);

        $address = $input->getOption('interface');
        $port = $input->getOption('port');

        $server->listen($port, $address);
        Loop\run();
    }

}
