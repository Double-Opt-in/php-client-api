# Double Opt-in Client API (PHP)
[![Latest Stable Version](https://poser.pugx.org/Double-Opt-in/php-client-api/v/stable.svg)](https://packagist.org/packages/Double-Opt-in/php-client-api) [![Latest Unstable Version](https://poser.pugx.org/Double-Opt-in/php-client-api/v/unstable.svg)](https://packagist.org/packages/Double-Opt-in/php-client-api) [![License](https://poser.pugx.org/Double-Opt-in/php-client-api/license.svg)](https://packagist.org/packages/Double-Opt-in/php-client-api) [![Total Downloads](https://poser.pugx.org/Double-Opt-in/php-client-api/downloads.svg)](https://packagist.org/packages/Double-Opt-in/php-client-api)

The PHP client api for Double Opt-in lets you integrate the double-opt.in service to your application by using its api.
 The api is an OAuth 2.0 REST api. You need an account at double-opt.in and a site to log the data to. All user-related 
 data will be hashed or crypted before sending to the server api. So all hashing and encrypting will be done on your 
 client side. We have NO plain text data from your users or customers. (Except the name of the optional scope right now.)

## Installation

Add to your composer.json following lines

	"require": {
		"double-opt-in/php-client-api": "~1.0"
	}

## Usage

For a running example you can take a look at the 
 [double-opt-in/cli-client-php](/Double-Opt-in/cli-client-php) package.

In general you will need the client for communication and a command for sending your business command.


### The communication client

	$clientId = 'YOUR_CLIENT_ID';
	$clientSecret = 'YOUR_CLIENT_SECRET';
	$siteToken = 'YOUR_SITE_TOKEN';
	
	// this is only one way to get a configuration instance
	$config = new DoubleOptIn\ClientApi\Config\ClientConfig($clientId, $clientSecret, $siteToken);
	
	// this is your api client which handles all requests and responses to the api server
	$api = new DoubleOptIn\ClientApi\Client\Api($config);

You can also store the configuration values in a file.


### The commands

Basically we can log an action for email, retrieve all actions for email and validate an email. For every single task we
 have a concrete command.


#### ActionsCommand

The ActionsCommand retrieves all actions stored for an email.

	$email = 'email-to@look.at';
	$actionsCommand = new DoubleOptIn\ClientApi\Client\Commands\ActionsCommand($email);

Sending the command and retrieving the actions:

	$response = $client->send($actionsCommand);

The response has a `data` part and a `meta` part. You can access them like so:

	$data = $response->decoded()->data;
	$meta = $response->decoded()->meta;

Data has an array of entries with the actions content. You have an example at
 [ActionsCommandResponse::toString()](/Double-Opt-in/php-client-api/blob/master/src/Client/Commands/Responses/ActionsCommandResponse.php).

Meta has a pagination object for going to the next result pages.


#### LogCommand

The LogCommand will be used to log an action for an email. 

> **ATTENTION**: We never store user-related data by this api! We hash and encrypt data before we send it.

	$email = 'email-to@log.now';
	$action = 'register';
	$logCommand = new DoubleOptIn\ClientApi\Client\Commands\LogCommand($email, $action);

Sending the command to the api service:

	$response = $client->send($logCommand);

You can set almost every word or action name you want. There are special names set to the site as actions workflow. 
 These actions control the state of an user. This is the action state you have to validate before sending him an email.
 These actions are `register -> confirm -> blacklist` by default. So if your user is blacklisted, you are not able to 
 send him an email newsletter for example. Only when a user is confirmed you can mail him with marketing information. 
 So the legal agreement.

As a result you get the entry created right now.


#### ValidateCommand

The ValidateCommand is for validating a user before sending him an email.

	$email = 'email-to@validate.at';
	$validateCommand = new DoubleOptIn\ClientApi\Client\Commands\ValidateCommand($email);

> You can validate an email globally or for a defined scope. But with hashed and encrypted data, we can only return data, 
> which is in our database. So if you have logged an email with action and scope, you only can validate by adding the 
> optional second argument scope.

Sending the command to the api service:

	$response = $client->send($validateCommand);
	$action = $response->decoded()->data->action;

In `$action` is the most-recent action from the actions workflow. So not the most-recent action at all, only the action
 from the workflow. By default one of the `register`, `confirm` or `blacklist`.

Be careful of adding (logging) the right action (with or without scope) for an user.
