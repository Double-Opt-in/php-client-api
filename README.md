# Double Opt-in Client API (PHP)
[![Latest Stable Version](https://poser.pugx.org/Double-Opt-in/php-client-api/v/stable.svg)](https://packagist.org/packages/Double-Opt-in/php-client-api) [![Latest Unstable Version](https://poser.pugx.org/Double-Opt-in/php-client-api/v/unstable.svg)](https://packagist.org/packages/Double-Opt-in/php-client-api) [![License](https://poser.pugx.org/Double-Opt-in/php-client-api/license.svg)](https://packagist.org/packages/Double-Opt-in/php-client-api) [![Total Downloads](https://poser.pugx.org/Double-Opt-in/php-client-api/downloads.svg)](https://packagist.org/packages/Double-Opt-in/php-client-api)

The PHP client api for Double Opt-in lets you integrate the double-opt.in service to your application by using its api.
 The api is an OAuth 2.0 REST api. You need an account at double-opt.in and a site to log the data to. All user-related 
 data will be hashed or crypted before sending to the server api. So all hashing and encrypting will be done on your 
 client side. We have NO plain text data from your users or customers. (Except the name of the optional scope right now.)

## Installation

Add to your composer.json following lines

	"require": {
		"double-opt-in/php-client-api": "~1.6"
	}

## Usage

For a running example you can take a look at the 
 [double-opt-in/cli-client-php](https://github.com/Double-Opt-in/cli-client-php) package.

In general you will need the client for communication and a command for sending your business command.


### The communication client

	$clientId = 'YOUR_CLIENT_ID';
	$clientSecret = 'YOUR_CLIENT_SECRET';
	$siteToken = 'YOUR_SITE_TOKEN';
	
	// this is only one way to get a configuration instance
	$config = new DoubleOptIn\ClientApi\Config\ClientConfig($clientId, $clientSecret, $siteToken);
	// bypass ssl verification with the following setting
	// $config->setHttpClientConfig(['verify' => false]);
	
	// this is your api client which handles all requests and responses to the api server
	$api = new DoubleOptIn\ClientApi\Client\Api($config);

You can also store the configuration values in a file.

#### Alternative ways to configure the client

*Hint*: For the `http_client` configuration values please look to the guzzle configuration values. We use the guzzle http 
 client internal.

##### 1. Use a file

For using a configuration file you have to use the ConfigFactory: 

	$config = \DoubleOptIn\ClientApi\Config\ConfigFactory::fromFile(__DIR__.'/config.php');
    $client = new DoubleOptIn\ClientApi\Client\Api($config);
    
The file has to have the following content:
	
	<?php // config.php
	return array(
	    'api' => 'https://www.double-opt.in/api', // optional
	    'client_id' => 'YOUR_CLIENT_ID',
	    'client_secret' => 'YOUR_CLIENT_SECRET',
	    'site_token' => 'YOUR_SITE_TOKEN',
	    // optional cache file, recommended for better performance
	    'cache_file' => 'path/to/writable/cachedir',
	    // optional http client configuration values
	    'http_client' => array(
	        'verify' => false,
		),
	);


##### 2. Use an array

For using array configuration you have to use the ConfigFactory as well:

	$config = \DoubleOptIn\ClientApi\Config\ConfigFactory::fromArray($configArray);
    $client = new DoubleOptIn\ClientApi\Client\Api($config);

You need the following structure for your array:

	$configArray = array(
    	'api' => 'https://www.double-opt.in/api', // optional
    	'client_id' => 'YOUR_CLIENT_ID',
    	'client_secret' => 'YOUR_CLIENT_SECRET',
    	'site_token' => 'YOUR_SITE_TOKEN',
    	// optional cache file, recommended for better performance
    	'cache_file' => 'path/to/writable/cachedir',
    	// optional http client configuration values
    	'http_client' => array(
			'verify' => false,
		),
	);

##### 3. Instantiate a ClientConfig object

You can also set a configuration instance manually:

	$config = new DoubleOptIn\ClientApi\Config\ClientConfig($clientId, $clientSecret, $siteToken, $apiUrl, $httpClientConfig);
	$client = new DoubleOptIn\ClientApi\Client\Api($config);

That's it.

#### Cache File option

The ClientConfig object has the ability to cache an bearer token for its lifetime. It is recommended for better 
 performance. The given cache file will be automatically appended with site token and client id to get a unique cache
 for a concrete connection.

Using the cache for the requested OAuth Access Token means the next request does not need any extra request for fetching
 an access token again. Each next request uses the fetched access token again.

Manually setting can be done by doing this:

	$config = new DoubleOptIn\ClientApi\Config\ClientConfig($clientId, $clientSecret, $siteToken, $apiUrl, $httpClientConfig);
	$config->setAccessTokenCacheFile('path/to/writable/cachedir/or-file-prefix');
	$client = new DoubleOptIn\ClientApi\Client\Api($config);
	
Or use the config option as array with special key `cache_file`.


### The commands

Basically we can log an action for email, retrieve all actions for email and validate an email. For every single task we
 have a concrete command. For administrative information you can request the current status too.


#### ActionsCommand

The ActionsCommand retrieves all actions stored for an email.

	$email = 'email-to@look.at';
	$actionsCommand = new DoubleOptIn\ClientApi\Client\Commands\ActionsCommand($email[, $action[, $scope]]);

Sending the command and retrieving the actions:

	$response = $client->send($actionsCommand);

The response has a `data` part and a `meta` part. You can access them like so:

	$data = $response->data();
	$meta = $response->meta();
	$actions = $response->all();

Data has an array of entries with the actions content. You have an example at
 [CommandResponse::all()](/Double-Opt-in/php-client-api/blob/master/src/Client/Commands/Responses/CommandResponse.php).

Meta has a pagination object for going to the next result pages.


#### LogCommand

The LogCommand will be used to log an action for an email. 

> **ATTENTION**: We never store user-related data by this api! We hash and encrypt data before we send it.

	$email = 'email-to@log.now';
	$action = 'register';
	$logCommand = new DoubleOptIn\ClientApi\Client\Commands\LogCommand($email, $action[, $scope]);

Optional you can force the necessary attributes `ip`, `useragent` and `created_at` by using this methods:

	$logCommand->setIp('127.0.0.1');
	$logCommand->setUseragent('My own useragent/1.0');
	$logCommand->setCreatedAt('2014-12-13 12:34:56');// or use a \DateTime instance

Sending the command to the api service:

	$response = $client->send($logCommand);
	$action = $response->action();

You can set almost every word or action name you want. There are special names set to the site as actions workflow. 
 These actions control the state of an user. This is the action state you have to validate before sending him an email.
 These actions are `register -> confirm -> blacklist` by default. So if your user is blacklisted, you are not able to 
 send him an email newsletter for example. Only when a user is confirmed you can mail him with marketing information. 
 So the legal agreement.

As a result you get the entry created right now.


#### ValidateCommand

The ValidateCommand is for validating a user before sending him an email.

	$email = 'email-to@validate.at';
	$validateCommand = new DoubleOptIn\ClientApi\Client\Commands\ValidateCommand($email[, $scope]);

> You can validate an email globally or for a defined scope. But with hashed and encrypted data, we can only return data, 
> which is in our database. So if you have logged an email with action and scope, you only can validate by adding the 
> optional second argument scope.

Sending the command to the api service:

	$response = $client->send($validateCommand);
	$action = $response->action();

In `$action` is the most-recent action from the actions workflow. So not the most-recent action at all, only the action
 from the workflow. By default one of the `register`, `confirm` or `blacklist`.

Be careful of adding (logging) the right action (with or without scope) for an user.


#### StatusCommand

The StatusCommand is for retrieving some status information.

	$statusCommand = new DoubleOptIn\ClientApi\Client\Commands\StatusCommand();

Sending the command to the api service:

	$response = $client->send($sendCommand);
	$status = $response->status();

In `$status` is an instance of the Status model (DoubleOptIn\ClientApi\Client\Commands\Responses\Models\Status). Here 
 you can access the following information:

- site name
- site type
- storage time in seconds for the stored data (time after last touch)
- credits left
- soft quota limit
- hard quota limit
- daily credits usage (approximation)
- unique mail hashes or identities
