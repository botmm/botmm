<?php


namespace botmm\ClientBundle\Controller;


use botmm\BufferBundle\Buffer\Hex;
use Exception;
use React\Dns\Resolver\Factory as DnsResolverFactory;
use React\EventLoop\Factory as LoopFactory;
use React\SocketClient\ConnectionInterface;
use React\SocketClient\DnsConnector;
use React\SocketClient\TcpConnector;
use React\Stream\Stream;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ReactPHPSocketController extends Controller
{

    /**
     * @Route("react_socket")
     */
    public function reactAction()
    {
        $loop = $this->get('teknoo.reactphp_bridge.vendor.loop');
        //$dnsResolverFactory = new Factory();
        //$dns = $dnsResolverFactory->createCached('8.8.8.8', $loop);
        //
        //$tcp = new TcpConnector($loop);
        //$dnsConnector = new DnsConnector($tcp, $dns);
        //
        //$dnsConnector->connect('www.baidu.com:8080')->then(function (ConnectionInterface $connection) {
        //    echo 'connected';
        //    $connection->write('...');
        //    $connection->end();
        //});

        $loginPack = $this->get('botmm_gradee.pack.login');

        $data = $loginPack->pack();

        $factory   = new DnsResolverFactory();
        $connector = new TcpConnector($loop);
        $dns       = $factory->create('8.8.8.8', $loop);

        $that = $this;

        $dns->resolve('msfwifi.3g.qq.com')->then(function ($ip) {
            echo "Host: $ip\n";
            return \React\Promise\resolve($ip);
        })->then(function ($ip) use ($connector, $data, $that) {
            $connector->connect("tcp://$ip:8080")->then(
                new class($data)
                {
                    protected $data;

                    public function __construct($data)
                    {
                        $this->data = $data;
                    }

                    public function __invoke(ConnectionInterface $connection)
                    {
                        // connection successfully established
                        $connection->on('data', function ($chunk) use ($that) {
                            $dispatcher = $that->get('event_dispatcher');

                        });

                        $connection->on('close', function () {

                        });

                        //dispatch Socket Connect
                        //listen Framework dispatch Request Event
                        $connection->write($this->data);
                    }
                },
                function (Exception $error) {
                    // failed to connect due to $error
                }
            );
        });


        return new Response("react socket");

    }

}