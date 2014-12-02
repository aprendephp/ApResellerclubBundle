ApResellerClubBundle
====================

### Example:

```php
		$this->resellerClub = $container->get('ap_resellerclub.api');

		$customerSignup = new CustomerSignup('anyuser@asf.com','anypass','A Good Name ', 'Company', 'Avenue 78890', 'San Jhon', 'San Jhon', null, 'UY','820347', '34', '87508745', 'es');

        $this->resellerClub->setOperation($customerSignup);
        $this->customerId = $this->resellerClub->exec();
```

PR are wellcome