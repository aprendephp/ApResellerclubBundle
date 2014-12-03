<?php
/**
 * Created by PhpStorm.
 * User: aprendephp
 * Date: 16/11/14
 * Time: 08:02 AM
 */

namespace Ap\ResellerclubBundle\Api\Contacts\Operations;

use Ap\ResellerclubBundle\Api\Contacts\Contacts;
use Ap\ResellerclubBundle\Api\Interfaces\OperationInterface;

class ContactAdd extends Contacts implements OperationInterface
{
    private $data;
    /**
     * @param $name 	String 	Required  Name of the Contact
     * @param $company 	String 	Required  Name of the Company
     * @param $email 	String 	Required 	Email address of the Contact
     * @param $addressLine1 	String 	Required 	First line of address of the Contact
     * @param $city 	String 	Required 	Name of the City
     * @param $country 	String 	Required Country code as per ISO 3166-1 alpha-2
     * @param $zipcode 	String 	Required 	ZIP code
     * @param $phoneCC String 	Required 	Telephone number country code
     * @param $phone 	String 	Required 	Telephone number
     * @param $customerId 	Integer 	Required 	The Customer under whom you want to create the Contact
     * @param $type 	String 	Required    The Contact Type. This can take following values:
     *                  Contact
     *                  CaContact
     *                  CnContact
     *                  CoContact
     *                  DeContact
     *                  EsContact
     *                  EuContact
     *                  NlContact
     *                  RuContact
     *                  UkContact or UkServiceContact
     * @param array $options
     */

    public function __construct($name, $company, $email, $addressLine1, $city, $country, $zipcode, $phoneCC, $phone, $customerId, $type, array $options = array())
    {
        $this->data['name'] = $name;
        $this->data['company'] = $company;
        $this->data['email'] = $email;
        $this->data['address-line-1'] = $addressLine1;
        $this->data['city'] = $city;
        $this->data['country'] = $country;
        $this->data['zipcode'] = $zipcode;
        $this->data['phone-cc'] = $phoneCC;
        $this->data['phone'] = $phone;
        $this->data['customer-id'] = $customerId;
        $this->data['type'] = $type;

        $this->data = array_merge($this->data, $options);
    }

    /**
     * @return string
     */
    public function getOperation()
    {
        return 'add';
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
