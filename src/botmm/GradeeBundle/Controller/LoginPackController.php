<?php


namespace botmm\GradeeBundle\Controller;


use botmm\GradeeBundle\Oicq\Tools\Hex;
use React\EventLoop\Factory as EventLoopFactory;
use React\Stream\Stream;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use swoole_client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


use React\Socket\Server as SocketServer;

/**
 * {@inheritDoc}
 */
class LoginPackController extends Controller
{

    /**
     * @Route("/loginpacksimple")
     */
    public function indexSimple()
    {
        $loginPack = $this->get('botmm_gradee.pack.login');

        $data = $loginPack->pack(true);
        return new Response(Hex::BinToHexString($data));
    }

    /**
     * @Route("/loginpack")
     */
    public function index()
    {
        $loginPack = $this->get('botmm_gradee.pack.login');

        $data = $loginPack->pack();
        //
        //$client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
        //$client->on("connect", function(swoole_client $cli) use($data){
        //    echo 'connected';
        //    $cli->send($data);
        //    $cli->send("GET / HTTP/1.1\r\n\r\n");
        //});
        //$client->on("receive", function(swoole_client $cli, $data){
        //    echo "Receive: $data";
        //    $cli->send(str_repeat('A', 100)."\n");
        //});
        //$client->on("error", function(swoole_client $cli){
        //    echo "error\n";
        //});
        //$client->on("close", function(swoole_client $cli){
        //    echo "Connection close\n";
        //});
        //if (!$client->connect('14.17.42.14', 8080)) {
        //    echo("connect failed. Error: {$client->errCode}\n");
        //}
        //$client->on('connect', function () use ($client, $data) {
        //    $client->send($data);
        //});
        //echo $client->recv();
        //$client->close();


        return new Response(Hex::BinToHexString($data));

    }

    /**
     * @Route("/login")
     */
    public function login()
    {
        $loginPack = $this->get('botmm_gradee.pack.login');
        //
        $data = $loginPack->pack();


        $loop = EventLoopFactory::create();

        //$this->resolveDns($loop)
        //     ->then(function ($ip) use ($loop, $data) {
        //         echo "Host: $ip\n";

        $client = stream_socket_client("tcp://14.17.42.14:8080");
        $conn   = new Stream($client, $loop);
        $conn->pipe(new Stream(STDOUT, $loop));
        $conn->write($data);

        $conn->on('data', function ($chunk) use ($conn) {
            echo $chunk;
            $conn->close();
        });
        //}, function ($e) {
        //    echo "Error: {$e->getMessage()}\n";
        //});


        $loop->run();

    }


    private function resolveDns($loop)
    {
        $factory = new \React\Dns\Resolver\Factory();
        $dns     = $factory->create('8.8.8.8', $loop);

        $domain = 'msfwifi.3g.qq.com';

        $promise = $dns
            ->resolve($domain);
        //->then(function ($ip) {
        //    echo "Host: $ip\n";
        //    return $ip;
        //}, function ($e) {
        //    echo "Error: {$e->getMessage()}\n";
        //});

        echo "Resolving domain $domain...\n";
        return $promise;
    }

}