Zoho CRM library for PHP 5.3+
=============================

The Zoho CRM library is a specialized xml, json wrapper for make request to zoho API.

I often found myself repeating the same pattern for xml | json manipulation with this API over and over. This library implements that pattern.

At it's heart, the library maps xml string to entity classes elements for interact like PHP value objects.

The following assumptions are made:

* XML namespaces are used everywhere using psr-0 for autoload class, same with composer.
* All XML elements map to entities PHP classes.
* Elements are represented by classes entities. A class(entity) extends of "Zoho\CRM\Wrapper\Element", this gives you the ability to access the inherited method "deserializeXml()" for conver the values of xml into the object.

This is not your average XML library. The intention is not to make this super
simple, but rather very powerful for complex XML applications.

Installation
------------