<?php

namespace AppBundle\Tests\Controller;

use Ap\ResellerclubBundle\Api\Customers\Operations\CustomerDelete;
use Ap\ResellerclubBundle\Api\Customers\Operations\CustomerSignup;
use Ap\ResellerclubBundle\Api\Customers\Operations\CustomersSearch;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CustomersTest extends WebTestCase
{
    protected $resellerClub;

    public function setUp()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $this->resellerClub = $container->get('ap_resellerclub.api');
    }

    public function testSignup()
    {
        $customerSignup = new CustomerSignup('userjuan15@nen.com', 'Aasdfasd256', 'Juan Alvares', 'N/A', 'Callminas 78890', 'San Jose', 'San Jose', null, 'UY', '820347', '34', '87508745', 'es');

        $this->resellerClub->setOperation($customerSignup);

        $response = json_decode($this->resellerClub->exec(), true);

        $this->checkError($response);

        $this->assertInternalType("int", $response);
        $this->assertGreaterThan(0, $response);
    }

    /**
     * @depends testSignup
     */
    public function testCustomersSearch()
    {
        $searchCustomers = new CustomersSearch(2, 1);

        $this->resellerClub->setOperation($searchCustomers);

        $response = json_decode($this->resellerClub->exec(), true);

        $this->checkError($response);

        $this->assertGreaterThanOrEqual(0, $response['recsonpage']);
        $this->assertGreaterThanOrEqual(0, $response['recsindb']);
    }

    /**
     * @depends testCustomersSearch
     */
    public function testCustomerDelete()
    {
        $searchCustomers = new CustomersSearch(10, 1);
        $this->resellerClub->setOperation($searchCustomers);
        $response = json_decode($this->resellerClub->exec(), true);

        $this->checkError($response);
        if ($response['recsonpage'] >= 1) {
            unset($response['recsonpage']);
            unset($response['recsindb']);
        }

        foreach ($response as $customer) {
            $customerDelete = new CustomerDelete($customer['customer.customerid']);
            $this->resellerClub->setOperation($customerDelete);
            $response = json_decode($this->resellerClub->exec(), true);
            $this->checkError($response);
            $this->assertTrue($response);
        }
    }

    private function checkError($response)
    {
        if (isset($response['status'])) {
            if ($response['status'] == 'ERROR') {
                throw (new \Exception($response['message']));
            }
        }
    }
}
