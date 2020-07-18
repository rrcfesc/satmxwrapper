<?php

declare(strict_types=1);

namespace Rioxygen\SatMx\KeyHandler;
use RuntimeException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;


final class Certificate
{
    /** @var string */
    private $basePath;

    /** @var string */
    private $rfc;

    /** @var string */
    private $cerFile;

    /** @var string */
    private $keyFile;

    /** @var string */
    private $pemFile;

    /** @var string */
    private $password;

    public function __construct(
        string $basePath,
        string $rfc,
        string $password
    ) {
        $this->basePath = $basePath;
        $this->rfc = $rfc;
        $this->password = $password;
        $this->validateFilePath();
        $this->validateCerFile();
        $this->validateCertificatePassword();

    }

    private function validateCerFile():void
    {
        $process = new Process([
            'openssl',
            'x509',
            '-inform',
            'der',
            '-in',
           $this->cerFile,
            '-out',
            $this->pemFile,
        ]);
        $filesystem = new Filesystem();

        if (!$filesystem->exists($this->pemFile)) {
            throw new RuntimeException("Invalid cer File");
        }
    }

    private function validateCertificatePassword():void
    {

    }

    private function validateFilePath():void
    {

        $filesystem = new Filesystem();
        $cerFile = sprintf("%s/%s.cer", $this->basePath, $this->rfc);
        $keyFile = sprintf("%s/%s.key", $this->basePath, $this->rfc);
        if (!$filesystem->exists($cerFile)) {
            throw new RuntimeException("Missing cer file");
        }
        if (!$filesystem->exists($keyFile)) {
            throw new RuntimeException("Missing key file");
        }

        $this->cerFile = $cerFile;
        $this->keyFile = $keyFile;
        $this->pemFile = $cerFile = sprintf("%s/%s.pem", $this->basePath, $this->rfc);
    }
}
