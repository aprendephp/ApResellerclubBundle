<?php
namespace Ap\ResellerclubBundle\Api\Customers\Operations;

use Ap\ResellerclubBundle\Api\Customers\Customers;
use Ap\ResellerclubBundle\Api\Interfaces\OperationInterface;

/**
 * Created by PhpStorm.
 * User: aprendephp
 * Date: 18/11/14
 * Time: 04:41 AM
 */

class CustomerDelete extends Customers implements OperationInterface
{
    private $data;

    /**
     * @param $customerId : Customer Id of the Customer that you want to delete
     */
    public function __construct($customerId)
    {
        $this->data['customer-id'] = $customerId;
    }

    /**
     * @return string
     */
    public function getOperation()
    {
        return 'delete';
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
