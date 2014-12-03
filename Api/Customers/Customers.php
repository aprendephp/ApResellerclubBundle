<?php

namespace Ap\ResellerclubBundle\Api\Customers;

use Ap\ResellerclubBundle\Api\Interfaces\RequestTypeInterface;

class Customers implements RequestTypeInterface
{
    /**
     * @return string for example /contact/ or /domains/
     */
    public function getRequestType()
    {
        return '/customers/';
    }
}
