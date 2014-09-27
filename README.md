# Button
A fast and lightweight PHP 5.4+ nano router. Build API's and RESTful applications with ease. With Button, you can get one or more JSON responses on the same request.

## The hello world!
```php
$btn = new Button();
$btn->hook('GET', '/say/hello/:name', function($name){
	return "Hello ". $name ."!";
});
```
In the previous example, when you access to `/say/hello/john`, Button will run the anonymous function and will return the next JSON object:

```
[
    'Hello john!'
]
```

1. [Requirements](#requirements) 
2. Installation
3. [Usage](#usage)
    1. [Parameters](#parameters)
4. [Features](#features)
    1. [The routes](#the-routes)
    	1. [Simple routing](#simple-routing)
    	2. [Routing parameters](#routing-parameters)
    	3. [Optional parameters](#optional-parameters)
    2. Callbacks
    
## Requirements
Button requires PHP 5.4+ to run

## Installation

## Usage


```php
// first create the Button object
$btn = new Button();

//then, make the hook
$btn->hook($http_method, $pattern, $callback [, $ajax]);
```
### Parameters
<dl>
  <dt>$http_method</dt>
  <dd>A string indicating HTTP method. Possible options are GET, POST, PUT and DELETE (lower case is allowed).</dd>

  <dt>$pattern</dt>
  <dd>The route that matches the requests. Learn more about <a href="#the-routes">patterns</a>.</dd>

  <dt>$callback</dt>
  <dd>Function or array of functions to be run. Learn more about <a href="#callbacks">callbacks</a>.</dd>

  <dt>$ajax</dt>
  <dd>Optional. <strong>true</strong> runs the callback when the request is an ajax request. <strong>false</strong> runs when the request is not an ajax call. Otherwise, if it is skipped or a non-boolean value is passed, the <em>callback</em> runs always. </dd>
</dl>

## Features
### The routes
With Button you can map an URI to callback one function or an array of functions. You can define the same route for different HTTP method and Button will execute only the respective callback.

#### Simple routing

The basic way to make a route is write a simple URI
```php
$btn = new Button();
$btn->hook('GET', '/say/hello/', function(){
	return "Hello world!";
});
```
#### Route parameters
To create a parameter you need to append a colon to the parameter name in the route. You can define as many parameters as you need.
```php
$btn = new Button();
$btn->hook('GET', '/say/hello/:name/:surname', function($name, $surname){
  return "Hello ". $name . " " . $surname ;
});
```
The values are extracted from the URI and are passed as arguments to the function in order of occurrence. Isn't important the parameter name in the function, if the route is defined as `/foo/:some/:thing` and the function is defined as `function($a, $b)` the value of `:some` will be passed to `$a` and `:thing` to `$b`.

#### Optional parameters
The optional parameters are defined within parentheses. If you use one or more optional parameters you can declare the parameter in the function with a value by default or not.
```php
$btn = new Button();
$btn->hook('GET', '/say/hello(/:name(/:surname))', function($name='John', $surname='Doe'){
  return "Hello ". $name . " " . $surname ;
});
```
This route can accepts requests for:
```
/say/hello
/say/hello/Jane
/say/hello/Jane/Roe
```
### Callbacks
