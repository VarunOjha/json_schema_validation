# Laravel 5.2 JSON Schema Validator example

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

JSON Schema Validation

HTTP Post ? You wish take a JSON as a web request and process it.
However, before you proceed to database inserts/updates you must make sure that you've recieved the required fields in the JSON Payload. 

Instead of writing nested if-else statements, which check for which field is present or not in the request JSON, you should use JSON Schema Validation.

The purpose of this application is demonstrate how to validate incoming request JSON against a decided JSON Schema. To achieve, I have writting a Utility Class over justinrainbow package in Laravel 5.2




Online tool to generate JSON Schema from a sample JSON (JSON Stubs) : http://jsonschema.net/
