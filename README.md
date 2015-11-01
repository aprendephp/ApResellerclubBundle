ApResellerClubBundle
====================

### Instalation:
Add this line in composer.json

``` bash
	"require": { 
	     ...
         "ap/resellerclubbundle": "1.0.*@dev"
```

AppKernel.php
``` php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Ap\ResellerclubBundle\ApResellerclubBundle(),
    );
}
```

Update:
``` bash
  composer update
```

### Configuration:
In parameters.yml
``` yml
    reseller_authuserid:
    reseller_apikey:
    reseller_test:
``` 

### Example:
```php
		$this->resellerClub = $container->get('ap_resellerclub.api');

		$customerSignup = new CustomerSignup('anyuser@asf.com','anypass','A Good Name ', 'Company', 'Avenue 78890', 'San Jhon', 'San Jhon', null, 'UY','820347', '34', '87508745', 'es');

        $this->resellerClub->setOperation($customerSignup);
        $this->customerId = $this->resellerClub->exec();
```

### Important:
[Testing ONLY with a Demo Account](http://cp.onlyfordemo.net/servlet/ResellerSignupServlet?&validatenow=false)

### Disclaimer:
THIS SOFTWARE IS PROVIDED BY "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES


PR are wellcome