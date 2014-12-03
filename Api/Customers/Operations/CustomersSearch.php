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

class CustomersSearch extends Customers implements OperationInterface
{
    private $data;

    /**
     * @integer $noOfRecords  Number of records to be fetched. This should be a value between 10 to 500.
     * @integer $pageNo  Page number for which details are to be fetched
     * @param array $options
     */
    public function __construct($noOfRecords, $pageNo, array $options = [])
    {
        $this->data['no-of-records'] = $noOfRecords;
        $this->data['page-no'] = $pageNo;

        $this->data = array_merge($this->data, $options);
    }

    /**
     * @return string
     */
    public function getOperation()
    {
        return 'search';
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
