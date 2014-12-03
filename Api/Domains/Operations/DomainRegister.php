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

class DomainRegister extends Domains implements OperationInterface
{
    private $data;
    private $extraData;

    /**
     * @param $domainName
     * @param $years
     * @param $customerId
     * @param $regContactId
     * @param $adminContactId
     * @param $techContactId
     * @param $billingContactId
     * @param $invoiceOption : This will decide how the Customer Invoice will be handled. Set any of below mentioned Invoice Options for your Customer:
     *            NoInvoice:   This will not raise any Invoice. The Order will be executed.
     *            PayInvoice:  This will raise an Invoice and:
     *                         if there are sufficient funds in the Customer's Debit Account, then the Invoice will be paid and the Order will be executed.
     *                         if there are insufficient funds in the Customer's Debit Account, then the Order will remain pending in the system.
     *            KeepInvoice: This will raise an Invoice for the Customer to pay later. The Order will be executed.
     */
    public function __construct($domainName, $years, $customerId, $regContactId, $adminContactId, $techContactId, $billingContactId, $invoiceOption, array $options = array())
    {
        $this->data['domain-name'] = $domainName;
        $this->data['years'] = $years;
        $this->data['customer-id'] = $customerId;
        $this->data['reg-contact-id'] = $regContactId;
        $this->data['admin-contact-id'] = $adminContactId;
        $this->data['tech-contact-id'] = $techContactId;
        $this->data['billing-contact-id'] = $billingContactId;
        $this->data['invoice-option'] = $invoiceOption;

        $this->extraData = '';

        $this->data = array_merge($this->data, $options);
    }

    public function getOperation()
    {
        return 'register';
    }

    public function getData()
    {
        return $this->data;
    }

    public function setExtraData($dnss)
    {
        foreach ($dnss as $dns) {
            $this->extraData = $this->extraData.'ns='.$dns.'&';
        }
        $this->extraData = substr($this->extraData, 0, -1);

        return $this;
    }

    /**
     * @return string
     */
    public function getExtraData()
    {
        return $this->extraData;
    }
}
