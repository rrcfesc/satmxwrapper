<?php declare(strict_types=1);

namespace Rioxygen\SatMx\KeyHandler;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;
use RuntimeException;

class CertificateTest extends TestCase
{
    /** @var string */
    private $fixDirectory;

    public function setUp(): void
    {
        parent::setUp();
        $this->fixDirectory = sprintf("%s/fixtures", realpath(__DIR__."/../"));
    }

    public function testCertificate()
    {
        $rfc = "rfc";
        $password = "password";
        $certificateHandler = new Certificate(
            $this->fixDirectory,
            $rfc,
            $password
        );
        $pemFile = sprintf("%s/%s.pem", $this->fixDirectory, $rfc);
        $keyFile = sprintf("%s/%s.key", $this->fixDirectory, $rfc);
        $this->assertEquals($pemFile, $certificateHandler->getPemFile(), "Miss match Pem path");
        $this->assertEquals($keyFile, $certificateHandler->getKeyFile(), "Miss match Key path");
        $this->assertEquals($password, $certificateHandler->getPassword(), "Miss match Password");

    }

    /**
     * @dataProvider getData
     */
    public function testExceptions(
        string $rfc,
        string $password,
        bool $createCer,
        bool $createKey,
        string $exceptionMessage
    ) {
        $filesystem = new Filesystem();
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage($exceptionMessage);
        $filesystem->remove(sprintf("%s/%s.cer", $this->fixDirectory, $rfc));
        $filesystem->remove(sprintf("%s/%s.key", $this->fixDirectory, $rfc));

        if ($createCer) {
            $filesystem->touch(sprintf("%s/%s.cer", $this->fixDirectory, $rfc));
        }
        if ($createKey) {
            $filesystem->touch(sprintf("%s/%s.key", $this->fixDirectory, $rfc));
        }
        $certificateHandler = new Certificate(
            $this->fixDirectory,
            $rfc,
            $password
        );


    }

    public function getData(): array
    {
        return [
            ['rucr860806s2a2as', 'asd', false, true, "Missing cer file"],
            ['rucr860806s2a2as', 'asd', true, false, "Missing key file"],
            ['rucr860806s2a2as', 'asd', true, true, "Invalid cer File"],
            ['rucr860806s2a2as', 'asd', false, false, "Missing cer file"],
        ];
    }

}
