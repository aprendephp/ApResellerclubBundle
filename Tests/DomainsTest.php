<?php

namespace AppBundle\Tests\Controller;

use Ap\ResellerclubBundle\Api\Contacts\Operations\ContactAdd;
use Ap\ResellerclubBundle\Api\Customers\Operations\CustomerSignup;
use Ap\ResellerclubBundle\Api\Domains\Operations\DomainRegister;
use Ap\ResellerclubBundle\Api\Domains\Operations\DomainRenew;
use Ap\ResellerclubBundle\Api\Domains\Operations\DomainsSearch;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DomainsTest extends WebTestCase
{
    protected $resellerClub;
    protected $customerId;
    protected $contactId;

    public function setUp()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $this->resellerClub = $container->get('ap_resellerclub.api');

        $customerSignup = new CustomerSignup('userjuan45@nen.com', 'Aasdfasd256', 'Juan Alvares', 'N/A', 'Callminas 78890', 'San Jose', 'San Jose', null, 'UY', '820347', '34', '87508745', 'es');
        $this->resellerClub->setOperation($customerSignup);
        $this->customerId = $this->resellerClub->exec();

        $contactAdd = new ContactAdd('Tom', 'N/A', 'userjuan45@nen.com', 'la luna 456', 'Ciudad de la paz', 'UY', '134235', '34', '452343452', $this->customerId, 'Contact');
        $this->resellerClub->setOperation($contactAdd);
        $this->contactId = $this->resellerClub->exec();
    }

    public function testDomainRegister()
    {
        $registerDomain = new DomainRegister('ialerebaso.com', '1', $this->customerId, $this->contactId, $this->contactId, $this->contactId, $this->contactId, 'NoInvoice');
        $registerDomain->setExtraData(['ns1.onlyfordemo.net', 'ns2.onlyfordemo.net']);

        $this->resellerClub->setOperation($registerDomain, $registerDomain->getExtraData());
        $response = json_decode($this->resellerClub->exec(), true);
        $this->checkError($response);
        ladybug_dump($response);
        $this->assertEquals('Success', $response['actionstatus']);
    }

    public function testSearchDomains()
    {
        $searchDomains = new DomainsSearch(10, 1, ['domain-name' => 'ialerebaso.com']);
        $this->resellerClub->setOperation($searchDomains);

        $response = json_decode($this->resellerClub->exec(), true);

        $this->checkError($response);
        if ($response['recsonpage'] >= 1) {
            unset($response['recsonpage']);
            unset($response['recsindb']);
        }

        foreach ($response as $domain) {
            $this->assertGreaterThan(0, $domain['entity.entityid']);
        }
    }

    /**
     * @depends testSearchDomains
     */
    public function testRenewDomain()
    {
        $searchDomains = new DomainsSearch(10, 1, ['domain-name' => 'ialerebaso.com']);
        $this->resellerClub->setOperation($searchDomains);

        $response = json_decode($this->resellerClub->exec(), true);

        unset($response['recsonpage']);
        unset($response['recsindb']);

        $domainResponse = $response[1];

        $renewDomain = new DomainRenew($domainResponse['orders.orderid'], 1, $domainResponse['orders.endtime'], 'NoInvoice');
        $this->resellerClub->setOperation($renewDomain);
        $response = json_decode($this->resellerClub->exec(), true);
        ladybug_dump($response);
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
