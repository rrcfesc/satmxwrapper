<?php

declare(strict_types=1);

namespace Rioxygen\SatMx\KeyHandler;

final class Certificate
{
    /** @var string */
    private $certPath;

    /** @var string */
    private $keyPath;

    /** @var string */
    private $passwd;

    public function __construct(
        $certPath,
        $keyPath,
        $passwd
    ) {


    }

}
