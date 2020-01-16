<?php


namespace botmm\GradeeBundle\Command;


use botmm\BufferBundle\Buffer\Buffer;
use botmm\BufferBundle\Buffer\StreamInputBuffer;
use botmm\GradeeBundle\Oicq\Cypher\Cryptor;
use botmm\GradeeBundle\Oicq\Tools\Hex;
use botmm\PlatformBundle\PlatformInfo\QqInfo;
use swoole_client;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * 模拟0325001
 *
 * @package botmm\GradeeBundle\Command
 */
class SocketClientCommand extends ContainerAwareCommand
{

    //public $randKey = 'd7 00 31 ad 7e 72 e0 74 06 07 ab bf 5f 5e 23 31';

    protected function configure()
    {
        $this
            ->setName('botmm:socket:client')
            ->setDescription('Send a message using swoole socket');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $loginPack = $this->getContainer()->get('botmm_gradee.pack.login');

        $data = $loginPack->pack();

        $logger = $this->getContainer()->get('logger');
        $qqInfo = $this->getContainer()->get('botmm_platform.qq_info');
        $logger->debug("randkey: " . bin2hex($qqInfo->randKey));
        echo "randkey:" . Hex::BinToHexString($qqInfo->randKey) . "\n";

        $client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
        $client->on("connect", function (swoole_client $cli) use ($data) {
            echo 'connected';
            //$cli->send(Hex::HexStringToBin("000004810000000a0200000004000000000b32383637333031ea545c060dd98625f683f1dcb3c1e4f027388f442b18527c06ff928fcceb882cc855c8f244e9f22d5487e5595fc4acaf26a261a2d17fdec62500776bd539369584c2c7c7e659a49ef87037114d871de403665a81a7ea391ebeab8055fcd4d4e9aed733d48f358bfea741d98a7171875607e54841f528b47b85059a48d927ee22b18cbc2ca3cf0de34f2a2dd4e4e18f847430e20eb7b6abf7b632e29f3e59b00dd59f2422e5fb803c7e760a21a875ea10e3e32f7908bceb3928042323cd749c78881aec1bcef7e55541e81196eb18786ba7cc22d32d34d68e6f64e0ae23172211e1bf7720fbe6db8e44b09b18667d171422c47baba1bed45643dae6c5c2c8c0a536c19694e0949e0c87a75569280088aa4901a6929d968a03aacd47c208b7b753acea86780a1db2f2e63b18ccb823244c3b2fd9ba3571bb017c3b84c01cf1f46782dcc4cdcecc0f262c43e4656652815c0be7609dad98920c84ed085a5da043560723d31930fd34897de9186259d7a40e383aaa524e115741b4ca8a48650db6f786722b939dad2c4b6a8292cd25a668a3a7af5c763e58de5b88c591caea1fa00dfa220300569083504fb753a7ff89fa843623faf0112a107b108fc019254e35e595711774dfd677a3ec415e0cb9ce945a5763b73ee60ef81eb0fd6e4ce6fd6c9079aa010daaf10864558c60e91c69e073fc584a733f567d9ed4526581778835136b192d0939993766f765f58a253024a22b13db3ea9b44674ad32289d372895a401a535a42d0061b2c5ba01a5a2b8f180f11e78162934401ce7e6629ea0f6775cf50732c02ec686065e7e69c66e17789231a4393f61a37d12a68cca4de24a04669023d3ad61002110500565bf4301b7f4d6ce769b31675b895041719b07bd739504814d3d43e4b723697462437e8c8e190b1d221b64222a224682ed73811a09ef76c82ea2549eab8dfe59b4ea42b62cbc025ccbdc53484ba60f0ac37b461eaac5c7bdbc01f85ba2130799e9ceb696d021c96f33dc5befbad7a5aff0949896d0242444b948a446621bebeeb0b85d51693da9cc2f6a1f93006e2b390d039b7490dd8c0dc6b1cececfe5589c6fae989f110a677d127e1dc0b6ac98938a86b7b6495e3013357209f50b9dd4493794582e9fc7cdafb4c7848b23fcec27ac84cf04bae52cb6c4fd45e491b6e6cde79541a15062ae5f4942f33ee2687a80d1557a51a3cf98c79de9b9e3b8f9200d561a2b3b3bd137ffa11649b1d806820764e3dfa32a1d3928e634182e33a903d686dc724d0e5e978a3975bd0e1ae362387979c36ce977678f1823014fd6f877f4ad4dbed7146ab200e91ae8ac51ebdeb0923a080eed68194fc5389adad59653ed4c68dfc84502b2337ecbfc52f892ae39f08b9ec486aace546fbcc0828fe7f44e70c325ce98cbf0d30da2713e986eda34e72d0b5e06572904e1d10490901656ea618b560b2360f0699cab6850a3854401eb2d048f0e45d0fb75bf23cdea89f1d2de1cf87fa6e78efb3c3bbc324dc9483acdc82fde9fa6d2732db02c6a4ab72279d7725e1015533588218e58ce1d56fa4043a01e365ee1d2244c769e1ea7af"));
            $cli->send($data);
        });
        $client->on("receive", function (swoole_client $cli, $data) use ($qqInfo) {
            echo "----\n";
            echo "Receive: " . Hex::BinToHexString($data) . "\n";

            $input   = StreamInputBuffer::from($data);
            $headLen = $input->readInt32BE();
            $str     = $input->readHex(6);
            if ('00 00 00 0a 02 00' != $str && '00 00 00 0b 02 00' != $str) {
                echo 'error' . $str . "\n";
                echo Hex::BinToHexString($input->read());
                return;
            }

            $qq        = $input->read($input->readInt32BE() - 4);
            $encrypted = $input->read();
            $encrypted = Cryptor::decrypt($encrypted, 0, strlen($encrypted), pack('a16', null));
            $input     = StreamInputBuffer::from($encrypted);
            $input->readInt32BE();
            $input->readHex(12);

            $serviceCmd = $input->read($input->readInt32BE() - 4);

            $input->read($input->readInt32BE() - 4);
            $input->readInt32BE();

            $bodyLen = $input->readInt32BE();
            $input->readHex(3);
            $pcVer  = $input->readHex(2);
            $subCmd = $input->readHex(2);
            if ($pcVer == '1f 41' && $subCmd == '08 10') {
                $input->readHex(2);
                $uin = $input->readInt32BE();
                echo 'UIN: ' . $uin . "\n";
                $input->readHex(2);

                if ($input->readHex(1) == 'b4') {
                    $encrypted = $input->read();
                    $decrypted = Cryptor::decrypt($encrypted,
                                                  0,
                                                  strlen($encrypted) - 1,
                                                  $qqInfo->randKey);
                    $input     = StreamInputBuffer::from($decrypted);
                    $input->readHex(2);
                    if ($input->readHex(1) == 'b4') {
                        echo $input->readHex(8) . "\n";
                        $tlv172 = $input->readHex(2);
                        if ($tlv172 == '01 72') {
                            $rollbackSig     = $input->read($input->readInt16BE());
                            $qq              = $this->getContainer()->get('botmm_platform.qq_info');
                            $qq->rollbackSig = $rollbackSig;

                            $login           = $this->getContainer()->get('botmm_gradee.pack.login');
                            $login->isSecond = true;
                            $second          = $login->pack();
                            $cli->send($second);
                            echo "rollbackSig: " . Hex::BinToHexString($rollbackSig) . "\n";
                            echo "tgtgt: " . Hex::BinToHexString($qq->TGTGT) . "\n";
                        }
                    }

                }
            }


            //$cli->send(str_repeat('A', 100) . "\n");
        });
        $client->on("error", function (swoole_client $cli) {
            echo "error\n";
        });
        $client->on("close", function (swoole_client $cli) {
            echo "Connection close\n";
        });
        if (!$client->connect('14.17.42.14', 8080)) {
            echo("connect failed. Error: {$client->errCode}\n");
        }
    }

    /**
     * send:
     * 000000d90000000b0200008298000000000b323836373330313ae1ce3c7c111f23dfad0df0c9436dd1aa30725a15be8a1476e5e52c1f52ae7ccc1b030a1ded873dce229e5a0ed3ee36361dbcbe2394f013b752549e358eca85ecd68a70715d90d3ed2f2cff8d9d5c878da6abe43cb6a0bd51e066f0e5de488ea970c7928d22b8056af1728543b6ef8a438efdbaf7275902494236224f64a96917debd7e9c128233a23f0e01f14a32aacdcab08ff5a5ceedaf31260d22d75576685edffeb3fdd9d699d35f2ab1cf5e83742ef7a2f880771186bbbef58c06599e
     * send:
     * 000003d90000000b0200008297000000000b32383637333031c846b68edf159d8ab7df204288ae293862c1c09d7c13ab6e465da574fc11990c2aa3c8654aa8b082e0b11087701d2bda7d35e8f2a057597ecf84999ff5a14efaf6d49978116c311a9864296ab3d8866f9f80881fe59d03f7470ac2d56fe9b2285f840d900c4fc796337dfe63ea0cb269c19d4fd7fea07ad3263e092d3f43f2be81b454fcec6484c00e1a3b36e9e0aa33e09b1186674417aee3f47638d6ef654df0177639964ca149cb4cecfda635305a4e41a0c31da407aa60c5512b3799d85662ac6ada9492388f04de38f5d987dc96860df2ffb0275b5373beffe11f7368990f476cfed99bc34ed45efe1aa390b304f759b3ecfd74974e9a314e5cbe1f06b11b74a99a7f78587d2ecc6d5a23e19d66d7d52e1457b33670d19b06e9d9809ba1e7674c8b7a94f87afca72701a7222f51fadb778598bebb24f64096cd8cdc76631647d7098f3c2a6a138f9bbd84008bf4b45dbafc6c407fcbfe9a9ae0c687d45495826945e431050a7a13c0e2faeea39a17d2f0b6deef4431915e9927e189d574f2a288d248e162933c4da9bf4e57dee165746ede4710f58ee866fcc29c0b2bb37ffc366bb1dc67c14a5e784c19b25941f4d9e979407dacf925c327f1a2fb7b24c4ad81c71dc6462ed2ad2aa05f8ab910197bc4f2278233ddd5ab7beadbbcba8438cc2bf45b2b9ebca78d62fae9d088db3917e6b209a211e6b05e95f3f6d0b147fd354719b45f79fa1b669c257f1df265368aa5a30d14781988e11c3ccdf30b6bb520f29084c4c21f3d1121339b193468eeef032885bc201e5dcec0cdb9414ef5fdfacd31b249ee4639ed1e84ce8355fed3920d1dd8aaa87dee3be6e3a25b2cb65d8ab5827acb3329896ca525a9b8c47f5d529099619f635dacc7ff35f8efa90afcc97754e4d3bbf599c83e78a42dd6cc6f588ec0829b6c8f0b4f580cc481917a74042ee684dbc1aaa537d8184d652668a897f72cc6878abdbe13c62c99d9ab04789d50498cb1838d5d811e947bdc68b32eb9c6fe514d2e645c62293c54722930a9c8cbf9269b62e9fd55c4111017c0ca3d9be5d3070994634c7e2a81e50c5297312db91cdeb9329ed265a6e084256ac66ea22113b804752eaaa76e3cae0dea857f5a3e8113aa2e628c72e35b82f6bfd88bcd7fef177553d10d310ce1c7f9e4bf20329ca262bb42d6546908c6ba099575b14ca897f03e5767dbdc28961ba9b07b5897ab8c696231f4e10ab36c0c0ee19ce3f07fcf621fe46d67efa8f4e37e8e2001d73353e474e340aa323749640ab3f235be2d333a63262c346cdcfd85c9a699c226714a0cf40b4141aa896cd1b2a23d0d317ad7c8be4efacb05abdb09edea4b
     * recv:
     * 0000009d0000000b02000000000b32383637333031ec26413a11d862bec85e48b6c7dad3baa3da754bac88ec2498aba2ae9fef71349c459bf23fe5730bf07c6dac82cd2812a667c914be5f60ad29eee43c6f47ea50e14b1d579aada5bfb148482bdd7348a08d13ff39cec36f867b6f224c69ebbdef3d4342210be4e2dae16a10e3f915eabf1af8bc9f89ca27d79bc9e25c5c558551c192a293809a0b24
     * send:
     * 000003e10000000b0200008297000000000b32383637333031cac81aca4b86311bf926b119109cf61e0685adfbc1cc6e809e9249c8a8b2d5665779958d545913a5bb35fee8abfd6bd981024982d3cdbd7531631123409f5f32a265c67cd5bc25482c952828e19e539a878e2480fd74dbb0170462945bddefcc6e71426b4eb13ed40d4c4e74be20187914c741f65523248e25d8ac2ec6dadf7ab133ba5d3026b9215ee0bce7a79631a196caa73e33cd74905dea3ed34da70c46c01368eb3a6d57da0fbb7c26fa0cad5a6e4a922697f23f1cbb59a26a6618ee397c6481a09b4d80cafa01a86fffb319cfc872ad6c88bf623ceefd88251d36bd45d578f7da6269bbd4acaf2a7406da0eddf737b0903193e4fb9728bdfbb25a9b7f5bb3c72f5962c37411f8b2845ea367a0896fa1ef4f18461ca2680b13b7932bf9e619d85b39652e2f3975600eb288d3f22f835458ae79f85f4ba27deac2f2cd1cae6fd061538404411fdce5d52ccb6b48b5d33bc85eda26a935ac33c091e1a0553a0cfd8b589b24407b09f678e27ce1a1a62e6fd49cada9b195ab34624d3398be4007325f82cbd5f012fdd9e54d5f4bd78d02ffeefa81f12d193df4895c744791bda1845cc9816d81b3022f7dababe5ee8b759b6025f34183ef8b5fff2d28fccdc23a638f05bdc523ef57da16f02497d5eba898449560cbcbd2b63f4e5e6328f92b5a2c165fd23081e77f8a2d8ecdeaa7ffe6795201ee91edcf54e2d90c008f432e781bfff03842b5b5a0faf657b60ea79191e3537525791935dffede8e6271193979c16c0971b8cde2fbefb3bd6dd3c339b7e2400002256c46bed3b3db8177213a07c87916fb3695ef7c329bbf25316c0bde4ab5677ebc1f38168b13279692d6830b0033c4f1761728e163d943b4cb845aec5683d2e670c39d6fc8e5dc10b11f47e69f56510a814fbf973458a5bc22efdf366539dbd1b2afae6e19e7cb124cf35ae0623b197b000daab71b3acc9870fa21ee2dee82b9868ed52b14184cdcf2093a3d8eff7d29c06990ea4c0f9d99970b8e8941163a9746f6e14bdcca0e240bf1cb5229390611b8bc24faf93bd5a71905ee69258ac0e784b34efcd4458b64b4e5cadca0cbb279dbcd7217aa289b56d7036e01a432e895873d83528785f21d27e0773bacd0651c28c128a95a8f078a229188a1cbaddc55ae3032fe692caac26599fe699be8788a7939777be1cb9b66b0672329bf8555279b8dd02569b73e243e41a7a1ae8f7fdf6d2981b76fc481fc635bffcb7a545fd491f7c4cffeba3972e7294a1e56db0508265bbf4cfd848aeb9ff1847078e9cd690ea093cfec1bf1e24f4909dbcfddb36cb025752ad2209bbc897161792604ad9d31d30b5dfe24b5fd0559086cb31681d4cf44
     * recv:
     * 000000e50000000b02000000000b32383637333031a834a179262637cc8289a177a46e35f98b0b97b609693a5d71f139f0edc510c1c5f36afafe44cc4b757fbc85347d55f6fdd80d8480b3750a146c3562fc7af22871ce62e3923a537a9a9a794542fd0055b9c3c41540b23b0341224edbd0f17fe449e5d03833db62423529e76c8e8a5a190174378a731d81841393664b2e1b30a1fcbbafecce22ca424c069893f1fe284ac0f74212259d3297cf6a283c7f46043cd62c6d8eb789f73ca2c09504508368d4f105a46ae080162252be8d11e21c0c767f69f508d5f75630837d2b6fa1fbb26d
     */

}