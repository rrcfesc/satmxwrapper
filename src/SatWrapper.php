<?php

declare(strict_types=1);

namespace Rioxygen\SatMx;

use Rioxygen\SatMx\KeyHandler\Certificate;

final class SatWrapper
{
    /** @var Certificate */
    private $keys;

    /** @var string */
    private $endpoint;

    public function __construct(Certificate $keys, $endpoint)
    {
        $this->keys = $keys;
        $this->endpoint = $endpoint;
    }

}