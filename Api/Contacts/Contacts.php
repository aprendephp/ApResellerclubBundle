<?php

namespace Ap\ResellerclubBundle\Api\Contacts;

use Ap\ResellerclubBundle\Api\Interfaces\RequestTypeInterface;

class Contacts implements RequestTypeInterface
{
    /**
     * @return string for example /contact/ or /domains/
     */
    public function getRequestType()
    {
        return '/contacts/';
    }
}
