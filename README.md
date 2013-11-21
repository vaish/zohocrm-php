Zoho CRM library for PHP 5.3+
=============================

The Zoho CRM library is a specialized xml, json wrapper for make request to zoho API.

I often found myself repeating the same pattern for xml | json manipulation with this API over and over. This library implements that pattern.

At it's heart, the library maps xml string to entity classes elements for interact like PHP value objects.

The following assumptions are made:

* XML namespaces are used everywhere using psr-0 for autoload class, same with composer.
* All XML elements map to entities PHP classes.
* Elements are represented by classes entities. A class(entity) extends of `Zoho\CRM\Wrapper\Element`, this gives you the ability to access the inherited method "deserializeXml()" for conver the values of xml into the object.

This is not your average XML library. The intention is not to make this super
simple, but rather very powerful for complex XML applications.

Installation
------------

Using by composer, just add this parameters to your `composer.json` **using like repository, no composer package, composer it's just for installation**:
```json
	"require": {
		"zohocrm-php/zohocrm-php": "dev-master"
	},
	"autoload": {
		"classmap": [
			"vendor/zohocrm-php/zohocrm-php/src/"
		],	
		"psr-0": {
			"Zoho\\": "zohocrm-php/zohocrm-php/src/"
		}
	},	
	"repositories": [{
	    "type": "package",
	    "package": {
	        "name": "zohocrm-php/zohocrm-php",
	        "version": "dev-master",
	        "source": {
	            "url": "https://github.com/frangeris/zohocrm-php.git",
	            "type": "git",
	        	"reference": "master"
	        }
	    }
    }],	
```

Then, run `composer.phar update` and you should be good.


Mapping XML to entities elements
--------------------------------

Normally when writing an entity class parser using this tool, there will be a number of
elements that make sense to create using classes for.

A great example would be the `Lead` entity, is part by default of the package, can be found inside `Zoho\CRM\Wrapper\Element\Lead` element:

```php
class Lead
{
	private $leadOwner;
	private $salutation;
	private $firstName;
	private $title;

	/* etc, others fields... */
}	
```

You can use this entity like a been, and make your own implementation of XML assings, but if you wanna use this for mapping xml, it recommended extends the entity of `Zoho\CRM\Wrapper\Element`, something like this:

```php
use Zoho\CRM\Wrapper\Element;

class Lead extends Element
{
	private $leadOwner;
	private $salutation;
	private $firstName;
	private $title;

	/* etc, others fields... */
}	
```

Now for load the XML into the class just call the method of the parent:

```php
use Zoho\CRM\Entities\Lead;

$xmlstr = '
<Lead>
	<leadOwner>John Doe</leadOwner>
	<salutation>Mr.</salutation>
	<firstName>Max Doe</firstName>
	<title>Engineer</title>
</Lead>';

$lead = new Lead();
$lead->deserializeXml($xmlstr);

// All the properties are loaded into the object lead and can be acceded

echo $lead->leadOwner."\n";
echo $lead->salutation."\n";
echo $lead->firstName."\n";
echo $lead->title."\n";
```