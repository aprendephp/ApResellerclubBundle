<?php

namespace Ap\ResellerclubBundle\Api\Domains;

use Ap\ResellerclubBundle\Api\Interfaces\RequestTypeInterface;

class Domains implements RequestTypeInterface
{
    /**
     * @return string for example /contact/ or /domains/
     */
    public function getRequestType()
    {
        return '/domains/';
    }
}
