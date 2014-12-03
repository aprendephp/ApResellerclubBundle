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

class DomainsSearch extends Domains implements OperationInterface
{
    private $data;

    public function __construct($noofrecords, $pagenumber, array $options = array())
    {
        $this->data["no-of-records"] = $noofrecords;
        $this->data["page-no"] = $pagenumber;

        $this->data = array_merge($this->data, $options);
    }

    public function getOperation()
    {
        return 'search';
    }

    public function getData()
    {
        return $this->data;
    }
}
