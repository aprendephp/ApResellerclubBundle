<?php

namespace AppBundle\Tests\Controller;

use Ap\ResellerclubBundle\Api\Contacts\Operations\ContactAdd;
use Ap\ResellerclubBundle\Api\Customers\Operations\CustomerDelete;
use Ap\ResellerclubBundle\Api\Customers\Operations\CustomerSignup;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactsTest extends WebTestCase
{
    protected $resellerClub;
    protected $customerId;

    public function setUp()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $this->resellerClub = $container->get('ap_resellerclub.api');

        $customerSignup = new CustomerSignup('userjuan15@nen.com', 'Aasdfasd256', 'Juan Alvares', 'N/A', 'Callminas 78890', 'San Jose', 'San Jose', null, 'UY', '820347', '34', '87508745', 'es');
        $this->resellerClub->setOperation($customerSignup);
        $this->customerId = $this->resellerClub->exec();
    }

    public function testContactAdd()
    {
        $contactAdd = new ContactAdd('Tom', 'N/A', 'userjuan15@nen.com', 'la luna 456', 'Ciudad de la paz', 'UY', '134235', '34', '452343452', $this->customerId, 'Contact');
        $this->resellerClub->setOperation($contactAdd);
        $response = json_decode($this->resellerClub->exec(), true);

        $this->checkError($response);

        $this->assertInternalType("int", $response);
        $this->assertGreaterThan(0, $response);
    }

    private function checkError($response)
    {
        if (isset($response['status'])) {
            if ($response['status'] == 'ERROR') {
                throw (new \Exception($response['message']));
            }
        }
    }

    public function tearDown()
    {
        $customerDelete = new CustomerDelete($this->customerId);
        $this->resellerClub->setOperation($customerDelete);
        $response = json_decode($this->resellerClub->exec(), true);
        $this->checkError($response);
        $this->assertTrue($response);
    }
}
