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

class ContactsSearch extends Contacts implements OperationInterface
{
    private $data;
    /**
     * @param $customerId: The Customer for which you want to get the Contact Details
     * @param $noOfRecords
     * @param $pageNo
     * @param array $options
     *                       contact-id 	Array of Integers 	Optional 	Array of Contact Ids for listing of specific Contacts
     *                       status 		Array of Strings 	Optional 	List of Contact statuses. These can take any values from: InActive, Active, Suspended, Deleted
     *                       name 		String 				Optional 	Name of Contact
     *                       company 	String 				Optional 	Name of the Company
     *                       email 		String 				Optional 	Email address of the Contact
     *                       type 		String 				Optional 	Type of contact. Valid values are: Contact, CoopContact, UkContact, EuContact, Sponsor, CnContact, CoContact, CaContact, DeContact, EsContact.
     */

    public function __construct($customerId, $noOfRecords, $pageNo, array $options = null)
    {
        $this->data['customer-id'] = $customerId;
        $this->data['no-of-records'] = $noOfRecords;
        $this->data['page-no'] = $pageNo;
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
