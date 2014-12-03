<?php
/**
 * Created by PhpStorm.
 * User: aprendephp
 * Date: 16/11/14
 * Time: 04:13 PM
 */

namespace Ap\ResellerclubBundle\Api\Domains\Operations;

use Ap\ResellerclubBundle\Api\Domains\Domains;
use Ap\ResellerclubBundle\Api\Interfaces\OperationInterface;

class DomainRenew extends Domains implements OperationInterface
{
    private $data;

    public function __construct($orderId, $years, $expDate, $invoiceOption, array $options = array())
    {
        $this->data['order-id'] = $orderId;
        $this->data['years'] = $years;
        $this->data['exp-date'] = $expDate;
        $this->data['invoice-option'] = $invoiceOption;

        $this->data = array_merge($this->data, $options);
    }

    public function getOperation()
    {
        return 'renew';
    }

    public function getData()
    {
        return $this->data;
    }
}
