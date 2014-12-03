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

class CustomerSignup extends Customers implements OperationInterface
{
    private $data;

    /**
     * @param $username: an email address.
     * @param $passwd
     * @param $name
     * @param $company
     * @param $addressLine1
     * @param $city
     * @param $state
     * @param $otherState
     * @param $country
     * @param $zipcode
     * @param $phoneCC
     * @param $phone
     * @param $langPref
     * @param array $options
     *                       address-line-2 	String 	Optional 	Address line 2 of the Customer's address
     *                       address-line-3 	String 	Optional 	Address line 3 of the Customer's address
     *                       alt-phone-cc 	String 	Optional 	Alternate phone country code
     *                       alt-phone 	String 	Optional 	Alternate phone number
     *                       fax-cc 	String 	Optional 	Fax number country code
     *                       fax 	String 	Optional 	Fax number
     *                       mobile-cc 	String 	Optional 	Mobile country code
     *                       mobile 	String 	Optional 	Mobile number
     */
    public function __construct($username, $passwd, $name, $company, $addressLine1, $city, $state = 'Not Applicable', $otherState = null, $country, $zipcode, $phoneCC, $phone, $langPref, array $options = [])
    {
        $this->data['username'] = $username;
        $this->data['passwd'] = $passwd;
        $this->data['name'] = $name;
        $this->data['company'] = $company;
        $this->data['address-line-1'] = $addressLine1;
        $this->data['country'] = $country;
        $this->data['city'] = $city;
        $this->data['state'] = $state;

        if ($state == 'Not Applicable') {
            $this->data['other-state'] = $country;
        } else {
            $this->data['other-state'] = $otherState;
        }

        $this->data['country'] = $country;
        $this->data['zipcode'] = $zipcode;
        $this->data['phone-cc'] = $phoneCC;
        $this->data['phone'] = $phone;
        $this->data['lang-pref'] = $langPref;

        $this->data = array_merge($this->data, $options);
    }

    /**
     * @return string
     */
    public function getOperation()
    {
        return 'signup';
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
