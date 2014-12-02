<?php

namespace Ap\ResellerclubBundle\Api;
class Resellerapi2
{

	private $curl;

	private $beginquery;
	private $rformat;

	private $query;
	private $inlineVars;

	protected $dataquery;
	protected $authorization;
	protected $apirequesttype;

    public function __construct( $authuserid,  $apikey,  $test = NULL , $rformat = NULL)
    {
    	$rformat = $rformat ?  $rformat: "json";

		if( strcmp ( $rformat, "json" ) or  strcmp ( $rformat, "xml")){
			$this->rformat = $rformat;	
		}else{
			throw new \Exception('only json and xml are supported');
		}

    	if((strcmp ($authuserid, "") == 0) or (strcmp ($apikey, "") == 0)){
				throw new \Exception('authuserid or apikey is required');
    	}else{
	    	$this->authorization["auth-userid"] = urlencode ($authuserid);
	    	$this->authorization["api-key"]     = urlencode ($apikey);
    	}  			

    	$this->is_test 	= $test ?"test." : "";

    	$this->beginquery = "https://".$this->is_test."httpapi.com/api";

		$this->operation = "";

    	$this->curl = curl_init();
		curl_setopt($this->curl, CURLOPT_VERBOSE, 1);
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
	}

	/**
	 * [buildQuery description]
	 * @return Resellerapi 
	 */
	public function buildQuery()
	{
		$this->query = $this->beginquery.$this->apirequesttype.".".$this->rformat."?".http_build_query($this->authorization).'&'.http_build_query($this->dataquery);

		if($this->inlineVars) {
			$this->query = $this->query.$this->inlineVars;
		}
		return $this;
	}

	public function getQuery()
	{
		return $this->query;
	}

	public function execQuery()
	{
		curl_setopt($this->curl, CURLOPT_URL, $this->query);
		$this->inlineVars = $this->query = $this->dataquery = null;

		return curl_exec($this->curl);
	}

	public function close()
	{
	   return curl_close($this->curl);
	}

	/**
	 * Checks the availability of the specified domain name
	 * IMPORTANT This version only checks one domain name
	 * @param string  $domains  the domain name
	 * @param string  $tld      tld
	 * @param boolean $suggests Pass true if domain name suggestions are required. Default value is false.
	 */
/*	
	public function CheckAvailability(string $domains, string $tld, bool $suggests = NULL)
	{

		$this->setDomainOperation("available");

		$this->dataquery["domain-name"] 		= $domains;
		$this->dataquery["tlds"] 				= $tld;
		$this->dataquery["suggest-alternative"] = $suggests;

		return $this;
	}
*/
// Customer Operations

	private function setCostumerOperation($customer_operation){

		$this->apirequesttype = "/customers/".$customer_operation;

		return $this;
	}
	/**
	 * Gets the Customer details for the specified Customer Id.
	 * @param  $customerid Customer Id of the Customer
	 * @return Resellerapi
	 */
	public function customersDetailsbyid($customerId)
	{
		$this->setCostumerOperation('details-by-id');
		$this->dataquery["customer-id"] = $customerId;

		return $this;
	}

	public function findCustomers($noOfRecords, $pageNo, array $options = null)
	{
		$this->setCostumerOperation('search');
		$this->dataquery['no-of-records'] = $noOfRecords;
		$this->dataquery['page-no'] = $pageNo;
		$this->dataquery = array_merge($this->dataquery, $options);
		return $this;
	}

	/**
	 * @param array $options
	 * @return $this
	 */
	public function findOneCustomer(array $options = null)
	{
		$this->findCustomers(1, 1, $options);
		return $this;
	}

// Contacts operations

	/**
	 * @param $contactOperation
	 * @return $this
	 */
	private function setContacsOperation($contactOperation){

		$this->apirequesttype = "/contacts/".$contactOperation;

		return $this;
	}

	//Searching for Contacts

// Domain operations
	/**
	 * @param $apirequesttype
	 * @return $this
	 * @throws \Exception
	 */
	private function setDomainOperation($apirequesttype){

		if(ctype_alpha ($apirequesttype)){
			$this->apirequesttype = "/domains/".$apirequesttype;
		}else{
			throw new \Exception('the operation contains invalid characters');
		}
		return $this;
	}

	/**
	 * Gets a list of Domain Registration Orders matching the search criteria, along with the details.
	 * IMPORTANT Only required options are implemented
	 * @param integer $noofrecords Number of Orders to be fetched. This should be a value between 10 to 500.
	 * @param string  $pagenumber  Page number for which details are to be fetched
	 */
	public function domainsSearch($noofrecords, $pagenumber)
	{
		$this->setDomainOperation('search');
		$this->dataquery["no-of-records"] 	= $noofrecords;
		$this->dataquery["page-no"] 		= $pagenumber;

		return $this;
	}

// domain-name string
// years 	Integer
// ns 	Array of Strings 	Required  ns=ns1.domain.com ns=ns2.domain.com
// customer-id 	Integer 	Required
// reg-contact-id 	Integer 	Required
// admin-contact-id 	Integer 	Required
// tech-contact-id 	Integer 	Required
// billing-contact-id 	Integer 	Required
// invoice-option 	String 	Required
//       NoInvoice: This will not raise any Invoice. The Order will be executed.
//       PayInvoice: This will raise an Invoice and:
//                   if there are sufficient funds in the Customer's Debit Account, then the Invoice will be paid and the Order will be executed.
//                   if there are insufficient funds in the Customer's Debit Account, then the Order will remain pending in the system.
//       KeepInvoice: This will raise an Invoice for the Customer to pay later. The Order will be executed.
// purchase-privacy 	Boolean 	optional
// protect-privacy 	Boolean 	Optional
	/**
	 * @param $domainName
	 * @param $years
	 * @param array $ns
	 * @param $customerId
	 * @param $regContactId
	 * @param $adminContactId
	 * @param $techContactId
	 * @param $billingContactId
	 * @param $invoiceOption
	 * @param null $purchasePrivacy
	 * @param null $protectPrivacy
	 * @return $this
	 * @throws \Exception
	 */
	public function registerDomain($domainName, $years, array $ns, $customerId, $regContactId, $adminContactId,
								   $techContactId, $billingContactId, $invoiceOption, $purchasePrivacy = null, $protectPrivacy = null)
	{
		$this->setDomainOperation('register');

		$this->dataquery['domain-name'] = $domainName;
		$this->dataquery['years'] = $years;
		$this->dataquery['customer-id'] = $customerId;
		$this->dataquery['reg-contact-id'] = $regContactId;
		$this->dataquery['admin-contact-id'] = $adminContactId;
		$this->dataquery['tech-contact-id'] = $techContactId;
		$this->dataquery['billing-contact-id'] = $billingContactId;
		$this->dataquery['invoice-option'] = $invoiceOption;
		$this->dataquery['purchase-privacy'] = $purchasePrivacy;
		$this->dataquery['protect-privacy'] = $protectPrivacy;

		foreach($ns as $nameserver) {
			$this->inlineVars = $this->inlineVars.'&ns='.$nameserver;
		}
		return $this;
	}
}


