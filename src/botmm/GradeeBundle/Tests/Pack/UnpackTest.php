<?php


namespace botmm\GradeeBundle\Tests\Pack;


use Beta\B;
use botmm\BufferBundle\Buffer\Buffer;
use botmm\BufferBundle\Buffer\StreamInputBuffer;
use botmm\GradeeBundle\Oicq\Cypher\Cryptor;
use botmm\GradeeBundle\Oicq\Tools\Hex;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UnpackTest extends WebTestCase
{

    public $oicq;
    public $tgtgt;

    public function tearDown()
    {
        var_dump($this->oicq);
        var_dump($this->tgtgt);
    }

    public function getData()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/gradee/loginpack');

        //$this->assertContains('Hello World', $client->getResponse()->getContent());

        return [
            [
                $client->getResponse()->getContent()
            ],
            //[
            //    '00 00 03 d9
            //     00 00 00 0b
            //     02 00 00 82
            //     97 00
            //     00 00 00 0b 32383637333031
            //     c846b68edf159d8ab7df204288ae293862c1c09d7c13ab6e465da574fc11990c2aa3c8654aa8b082e0b11087701d2bda7d35e8f2a057597ecf84999ff5a14efaf6d49978116c311a9864296ab3d8866f9f80881fe59d03f7470ac2d56fe9b2285f840d900c4fc796337dfe63ea0cb269c19d4fd7fea07ad3263e092d3f43f2be81b454fcec6484c00e1a3b36e9e0aa33e09b1186674417aee3f47638d6ef654df0177639964ca149cb4cecfda635305a4e41a0c31da407aa60c5512b3799d85662ac6ada9492388f04de38f5d987dc96860df2ffb0275b5373beffe11f7368990f476cfed99bc34ed45efe1aa390b304f759b3ecfd74974e9a314e5cbe1f06b11b74a99a7f78587d2ecc6d5a23e19d66d7d52e1457b33670d19b06e9d9809ba1e7674c8b7a94f87afca72701a7222f51fadb778598bebb24f64096cd8cdc76631647d7098f3c2a6a138f9bbd84008bf4b45dbafc6c407fcbfe9a9ae0c687d45495826945e431050a7a13c0e2faeea39a17d2f0b6deef4431915e9927e189d574f2a288d248e162933c4da9bf4e57dee165746ede4710f58ee866fcc29c0b2bb37ffc366bb1dc67c14a5e784c19b25941f4d9e979407dacf925c327f1a2fb7b24c4ad81c71dc6462ed2ad2aa05f8ab910197bc4f2278233ddd5ab7beadbbcba8438cc2bf45b2b9ebca78d62fae9d088db3917e6b209a211e6b05e95f3f6d0b147fd354719b45f79fa1b669c257f1df265368aa5a30d14781988e11c3ccdf30b6bb520f29084c4c21f3d1121339b193468eeef032885bc201e5dcec0cdb9414ef5fdfacd31b249ee4639ed1e84ce8355fed3920d1dd8aaa87dee3be6e3a25b2cb65d8ab5827acb3329896ca525a9b8c47f5d529099619f635dacc7ff35f8efa90afcc97754e4d3bbf599c83e78a42dd6cc6f588ec0829b6c8f0b4f580cc481917a74042ee684dbc1aaa537d8184d652668a897f72cc6878abdbe13c62c99d9ab04789d50498cb1838d5d811e947bdc68b32eb9c6fe514d2e645c62293c54722930a9c8cbf9269b62e9fd55c4111017c0ca3d9be5d3070994634c7e2a81e50c5297312db91cdeb9329ed265a6e084256ac66ea22113b804752eaaa76e3cae0dea857f5a3e8113aa2e628c72e35b82f6bfd88bcd7fef177553d10d310ce1c7f9e4bf20329ca262bb42d6546908c6ba099575b14ca897f03e5767dbdc28961ba9b07b5897ab8c696231f4e10ab36c0c0ee19ce3f07fcf621fe46d67efa8f4e37e8e2001d73353e474e340aa323749640ab3f235be2d333a63262c346cdcfd85c9a699c226714a0cf40b4141aa896cd1b2a23d0d317ad7c8be4efacb05abdb09edea4b'
            //],
            [
                '000004810000000a0200000004000000000b32383637333031ea545c060dd98625f683f1dcb3c1e4f027388f442b18527c06ff928fcceb882cc855c8f244e9f22d5487e5595fc4acaf26a261a2d17fdec62500776bd539369584c2c7c7e659a49ef87037114d871de403665a81a7ea391ebeab8055fcd4d4e9aed733d48f358bfea741d98a7171875607e54841f528b47b85059a48d927ee22b18cbc2ca3cf0de34f2a2dd4e4e18f847430e20eb7b6abf7b632e29f3e59b00dd59f2422e5fb803c7e760a21a875ea10e3e32f7908bceb3928042323cd749c78881aec1bcef7e55541e81196eb18786ba7cc22d32d34d68e6f64e0ae23172211e1bf7720fbe6db8e44b09b18667d171422c47baba1bed45643dae6c5c2c8c0a536c19694e0949e0c87a75569280088aa4901a6929d968a03aacd47c208b7b753acea86780a1db2f2e63b18ccb823244c3b2fd9ba3571bb017c3b84c01cf1f46782dcc4cdcecc0f262c43e4656652815c0be7609dad98920c84ed085a5da043560723d31930fd34897de9186259d7a40e383aaa524e115741b4ca8a48650db6f786722b939dad2c4b6a8292cd25a668a3a7af5c763e58de5b88c591caea1fa00dfa220300569083504fb753a7ff89fa843623faf0112a107b108fc019254e35e595711774dfd677a3ec415e0cb9ce945a5763b73ee60ef81eb0fd6e4ce6fd6c9079aa010daaf10864558c60e91c69e073fc584a733f567d9ed4526581778835136b192d0939993766f765f58a253024a22b13db3ea9b44674ad32289d372895a401a535a42d0061b2c5ba01a5a2b8f180f11e78162934401ce7e6629ea0f6775cf50732c02ec686065e7e69c66e17789231a4393f61a37d12a68cca4de24a04669023d3ad61002110500565bf4301b7f4d6ce769b31675b895041719b07bd739504814d3d43e4b723697462437e8c8e190b1d221b64222a224682ed73811a09ef76c82ea2549eab8dfe59b4ea42b62cbc025ccbdc53484ba60f0ac37b461eaac5c7bdbc01f85ba2130799e9ceb696d021c96f33dc5befbad7a5aff0949896d0242444b948a446621bebeeb0b85d51693da9cc2f6a1f93006e2b390d039b7490dd8c0dc6b1cececfe5589c6fae989f110a677d127e1dc0b6ac98938a86b7b6495e3013357209f50b9dd4493794582e9fc7cdafb4c7848b23fcec27ac84cf04bae52cb6c4fd45e491b6e6cde79541a15062ae5f4942f33ee2687a80d1557a51a3cf98c79de9b9e3b8f9200d561a2b3b3bd137ffa11649b1d806820764e3dfa32a1d3928e634182e33a903d686dc724d0e5e978a3975bd0e1ae362387979c36ce977678f1823014fd6f877f4ad4dbed7146ab200e91ae8ac51ebdeb0923a080eed68194fc5389adad59653ed4c68dfc84502b2337ecbfc52f892ae39f08b9ec486aace546fbcc0828fe7f44e70c325ce98cbf0d30da2713e986eda34e72d0b5e06572904e1d10490901656ea618b560b2360f0699cab6850a3854401eb2d048f0e45d0fb75bf23cdea89f1d2de1cf87fa6e78efb3c3bbc324dc9483acdc82fde9fa6d2732db02c6a4ab72279d7725e1015533588218e58ce1d56fa4043a01e365ee1d2244c769e1ea7af'
            ],
            [
                '000004890000000a0200000004000000000b32383637333031e28d1d7ccbee40b1afc1388046c733635eb68a437ea6560f750f72a54340acf4e20fd37f81cacc1adc48bb3f9855d4f5e6a8e6cb7fd1acad2a1609e2a07b3cfc6f77823f445a2b716a50bd2ad4cc9d2008b2057c9c06c577df84191056782c46e9f4219a7d96a3533c3bcd31c7c1702cd8a4f76a3f760afa0707d12087960fd33feec400e09eb869b02f5249c0edfa4dd4da25432bbb160274823c1c40db72f729e1d769ed835253e8cd249de6f8d4efc277e1ee8b32ac0db1c3cf1387b81da7f17866821c035565b4bc182f0a106bda40dfbd9f4bf247b964c93e289479cf54bca6b13d549258b650dde97dfcffc49ee030186adc065121f8417460a8e56ede6b478e5d725887635cee12480b85ee8a44ad4a3caa1e6bcfe24a25f4bc850cc3fead67cd99364fb734c1b3e428058e4f73926ace9ce1f74eabbca2bd614ca8c64d02196b7d4d14715c69c6de9e34d55beb8c35e7dfc4c79a941025db16de6d754c3a1acacc5fcc9a189598887ebd9bdfb721e3780d77240b6b8f15af5ac9edab6e1fc0b4c8b86316ec51e32ed46f2e871b221e903c9914043bb56c8fb77dd97633c38897bd3834cce4d15258970890b28ad92c962efef823d7221c57c6b96a45c766b0764b8243794881d60af999df37ba680a40a6eede388f06b1ff6684ddeddc2141f920c21126f5dcac0346c784f85f9130a2b1f93e7f26bcb2abb017af4c4827f58f5eb8e9c89f85dff03863e9ab98450d9cdcdb3a1ca221ef73d96abc4917b1202b9cef47999b962e9ee26cc1f31ab043b571f3888bdf44fb099274972dd5e047be7437e2f57f0aa683fd522081dda71afd94fb1e875e4836a33487c690fb12b026807b2f7ed4f5533ec2835d209567853f7b6a713efbaddeaf917b201da3ff08bd2b8688b2dcfddce8509766936b2e9c669d60831bc74bc17a5ffc4da3efe3ace47e1142600e21a64b8f090e68e08038a16757d39de442dbaa78232d7e66cd927c2a8c559223d4cd9812d1ee955a679a3b83b903fdb1a5782eaec6cf369f566f36e6449a09090fdef9f804c8c09f080b74182bd86f14a84263a65d0e8abed029e6e7929c6c19680f13cc18070f33a70273bf5c5a7e5ea6418fac1f8d363ea5aabf68032c506fdce9b9845502cdf935d3b91e60a75be070c0fc7cc613c24bb4b4d62a56e79a2678bde38e7ea8389ba0b56635a3d499f502c0f112edf36aae61979fa8a96670a7a8d69a1f514540bfca2a6025906b0b7896dfc130836581eb39a18ef14605b0f7e2b3a26be6affc913fb146b68425021ab7b3c6bbb626ec256c2dbbf5d9bfc0f1653ab84b319e16958ddf9ee204730b9e615d078fe14b187887ded110aad89ba849c56d6a3757fa56ff18084921440e2b4247223855e55814a5aea241dbc0a9614a66d17ed76c06f046ffe941caf224e547d3f629181335d2b4afd782f129513f575d53c0df11aa9562513cfd0a5716feea2770b72d8725d152a2583bc20cd0dfabbbf85281068eba5d1e8d43c301ab7de3dc118c7b1b155e39f9a66d90a2587bc5a8c4d3cc1bf485b4084ee8abc6578cfdf1ef02e9187062e172e4e0601ac2be264e0a01a3a125'
            ]
        ];
    }

    public $data;

    /**
     * @dataProvider getdata
     * @param $data
     */
    public function testUnpak($data)
    {
        $this->data        = Hex::HexStringToBin($data);
        $streamInputBuffer = new StreamInputBuffer(Buffer::from($this->data));

        $len = $streamInputBuffer->readInt32BE();
        $this->assertEquals(strlen($this->data), $len);
        $head = $streamInputBuffer->readHex(10);
        $this->assertContains($head, [
            '00 00 00 0b 02 00 00 82 97 00',
            '00 00 00 0a 02 00 00 00 04 00'
        ]);

        //print Hex::BinToHexString($head);

        $qqLen = $streamInputBuffer->readInt32BE();
        $qq    = $streamInputBuffer->read($qqLen - 4);
        $this->assertEquals('2867301', $qq);
        echo $qq . "\n";

        $encrypted = $streamInputBuffer->read(strlen($this->data) - ($qqLen + 14));

        $data = Cryptor::decrypt($encrypted, 0, strlen($encrypted), pack('a16', null));

        if ($head == '00 00 00 0b 02 00 00 82 97 00') {
            $bin   = $this->parse0B02($data);
            $input = StreamInputBuffer::from($bin);
        } elseif ($head == '00 00 00 0a 02 00 00 00 04 00') {
            $bin   = $this->parse0A02($data);
            $input = StreamInputBuffer::from($bin);
        }


        $this->assertEquals('1f 41', $input->readHex(2));
        $this->assertEquals('08 10', $input->readHex(2));
        $oicq['seq'] = $input->readInt16BE();
        $this->assertEquals(2867301, $input->readInt32BE());
        $this->assertEquals('03', $input->readHex(1));
        $this->assertEquals('87', $input->readHex(1));
        $oicq['retry']          = $input->readInt8();
        $oicq['ext_type']       = $input->readInt32BE();
        $oicq['client_version'] = $input->readInt32BE();
        $oicq['ext_instance']   = $input->readInt32BE();
        $keyType = $input->readHex(2);
        if($keyType == '01 01'){
            $oicq['randKey'] = $input->readHex(16);
        }elseif ($keyType == '01 02'){
            $second = $input->readHex(16);
        }
        $this->assertEquals('01 02', $input->readHex(2));
        $oicq['pubKey'] = Hex::BinToHexString($input->read($input->readInt16BE()));
        $this->assertEquals('03 4b 6b 9f 22 ce c8 67 83 97 87 aa 32 06 7a e2 b3 bd 9d 57 8f 20 97 6d b4',
                            $oicq['pubKey']);

        $this->oicq = $oicq;
        $shareKeyEncrypted = $input->read();

        //tlv
        $decrypted = Cryptor::decrypt($shareKeyEncrypted, 0, strlen($shareKeyEncrypted),
                                      Hex::HexStringToBin('7d1ffc96239d17a236f122d2b497a300')
        );

        //echo Hex::BinToHexString($decrypted);

        $this->handleTlv($decrypted);

    }

    public function parse0B02($data)
    {
        $input = new StreamInputBuffer(Buffer::from($data));

        $headLen = $input->readInt32BE();
        //$headInfo['ssoSeq']   = $input->readInt32BE();
        //$headInfo['subAppId'] = dechex($input->readInt32BE());
        //$headInfo['wxAppId']  = dechex($input->readInt32BE());
        $headInfo['cmd']        = $input->read($input->readInt32BE() - 4);
        $headInfo['msgCookies'] = Hex::BinToHexString($input->read($input->readInt32BE() - 4));
        $headInfo['extBin']     = Hex::BinToHexString($input->read($input->readInt32BE() - 4));

        //oicq wupbuffer
        $bodyLen = $input->readInt32BE();
        $this->assertEquals('02', $input->readHex(1));
        $oicqLen = $input->readInt16BE();
        //$input   = new StreamInputBuffer(Buffer::from($input->read($oicqLen - 4)));
        return $input->read($oicqLen - 4);
    }

    public function parse0A02($data)
    {
        $input = new StreamInputBuffer(Buffer::from($data));

        $headLen              = $input->readInt32BE();
        $headInfo['ssoSeq']   = $input->readInt32BE();
        $headInfo['subAppId'] = dechex($input->readInt32BE());
        $headInfo['wxAppId']  = dechex($input->readInt32BE());
        $input->read(12);
        $headInfo['extBin']     = Hex::BinToHexString($input->read($input->readInt32BE() - 4));
        $headInfo['cmd']        = $input->read($input->readInt32BE() - 4);
        $headInfo['msgCookies'] = Hex::BinToHexString($input->read($input->readInt32BE() - 4));
        $headInfo['imei']       = $input->read($input->readInt32BE() - 4);
        $headInfo['ksid']       = Hex::BinToHexString($input->read($input->readInt32BE() - 4));
        $headInfo['ver']        = $input->read($input->readInt16BE() - 2);
        $headInfo['unknown']    = $input->read($input->readInt32BE() - 4);

        //oicq wupbuffer
        $bodyLen = $input->readInt32BE();
        $this->assertEquals('02', $input->readHex(1));
        $oicqLen = $input->readInt16BE();
        return $input->read($oicqLen - 4);
    }

    public function handleTlv($tlvs)
    {
        $input = new StreamInputBuffer(Buffer::from($tlvs));
        $this->assertEquals('00 09', $input->readHex(2));
        $this->assertEquals(24, $input->readInt16BE());


        $this->testTlv18($input);
        $this->testTlv1($input);
        $this->testTlv106($input);
    }

    public function testTlv18($input)
    {
        $this->assertEquals('00 18', $input->readHex(2));
        $tlv18Len = $input->readInt16BE();
        $this->assertEquals('00 01', $input->readHex(2));
        $this->assertEquals('00 00 06 00', $input->readHex(4));
        $this->assertEquals('00 00 00 10', $input->readHex(4));
        $this->assertEquals('00 00 00 00', $input->readHex(4));
        $this->assertEquals(2867301, $input->readInt32BE());
        $this->assertEquals(0, $input->readInt32BE());

    }

    public function testTlv1($input)
    {
        $this->assertEquals('00 01', $input->readHex(2));
        $len = $input->readInt16BE();
        $this->assertEquals('00 01', $input->readHex(2));
        $input->readHex(4);
        $this->assertEquals(2867301, $input->readInt32BE());
        echo date('Y-m-d H:i:s', $input->readInt32BE()) . "\n";
        $this->assertEquals('00 00 00 00 00 00', $input->readHex(6));
    }

    public function testTlv106($input)
    {
        $this->assertEquals('01 06', $input->readHex(2));
        $len = $input->readInt16BE();

        $encrypted = $input->read($len);

        $decrypted = Cryptor::decrypt($encrypted, 0, strlen($encrypted),
                                      md5(md5('thirstyzebra', true) . Hex::HexStringToBin('00 00 00 00 00 2B C0 65'),
                                          true)
        );

        $input = new StreamInputBuffer(Buffer::from($decrypted));

        $this->assertEquals('00 04', $input->readHex(2));
        echo $input->readHex(4) . "\n";
        $this->assertEquals('00 00 00 05', $input->readHex(4));
        $this->assertEquals('00 00 00 10', $input->readHex(4));
        $this->assertEquals('00 00 00 00', $input->readHex(4));
        $this->assertEquals('00 00 00 00', $input->readHex(4));
        $this->assertEquals(2867301, $input->readInt32BE());
        echo date('Y-m-d H:i:s', $input->readInt32BE()) . "\n";
        $this->assertEquals('00 00 00 00', $input->readHex(4));
        $this->assertEquals('01', $input->readHex(1));
        $this->assertEquals(md5('thirstyzebra', true), $input->read(16));
        $this->tgtgt = $input->readHex(16);
        $this->assertEquals('00 00 00 00', $input->readHex(4));
        $this->assertEquals('01', $input->readHex(1));

    }


}