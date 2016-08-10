# Laravel 5.2 JSON Schema Validator example

JSON Schema Validation

HTTP Post ? You wish take a JSON as a web request and process it.
However, before you proceed to database inserts/updates you must make sure that you've recieved the required fields in the JSON Payload. 

Instead of writing nested if-else statements, which check for which field is present or not in the request JSON, you should use JSON Schema Validation.

>The purpose of this application is demonstrate how to validate request JSON against a JSON Schema. To achieve this, I have written a Utilities Class over [justinrainbow's json-schema](https://github.com/justinrainbow/json-schema) package in Laravel 5.2

Let's say you are creating a new user.

```
API: http://localhost:8000/v1/register
HTTP Method: POST
Headers: Content-Type:application/json
```

Now, fields such as **username,password,email,phone,password** are required. Otherwise, a user cannot be created. 

Let's say you send the JSON below in the HTTP request. Clearly, some fields are missing.
Request JSON :
```javascript
{
  "username": "varun_ojha32",
  "first_name": "Varun",
  "last_name": "Ojha"
}
```

Since, the required fields **phone,email,password** are missing, obviously the JSON cannot be processed.

Desirable HTTP response for this request is:

```javascript
{
  "error": {
    "code": "INVALID_JSON_SCHEMA",
    "details": {
      "status": 0,
      "Register_SCHEMA": [
        {
          "field": "password",
          "issue": "The property password is required"
        },
        {
          "field": "email",
          "issue": "The property email is required"
        },
        {
          "field": "phone",
          "issue": "The property phone is required"
        }
      ],
      "Register_VALID": 0
    }
  }
}
```
Alongwith a HTTP status code 422. 

---
Implementation
Validate the request JSON at the controller level. Check app/Http/Controllers/UserController.php

```
	// Registering a user
    public function register(Request $request)
    {
        // Extract the JSON from the HTTP request
        $result = $request->getContent();

        if (isJson($result) == FALSE) {
            $result["error"]["code"] = "INVALID_JSON";
            return response()->json($result,422,[],JSON_NUMERIC_CHECK);  
        }
        // 'Register' is an alias to the JSON Schema for register

        $schemaCheck = JSONValidator::validate_json($result,'Register');
        if ($schemaCheck["status"] == 0) {
            $res["error"]["code"]                     = "INVALID_JSON_SCHEMA";
            $res["error"]["details"] = $schemaCheck;
            return response()->json($res,422,[],JSON_NUMERIC_CHECK); 
        }
        return response()->json($result,201,[],JSON_NUMERIC_CHECK);
    }

```
The corresponding JSON Schema is stored in a 'Schema' folder. 

JSON Schema for Register(app/Schema/Register.json):

```javascript
{
  "$schema": "http://json-schema.org/draft-04/schema#",
  "type": "object",
  "properties": {
    "username": {
      "type": "string",
      "minLength": 1
    },
    "first_name": {
      "type": "string",
      "minLength": 1
    },
    "last_name": {
      "type": "string",
      "minLength": 1
    },
    "password": {
      "type": "string",
      "minLength": 1
    },
    "email": {
      "type": "string",
      "minLength": 1
    },
    "phone": {
      "type": "string",
      "minLength": 1
    }
  },
  "required": [
    "username",
    "password",
    "email",
    "phone"
  ]
}
```

The Utility class written over justinrainbow's json-schema is present in app/Utilities directory.

This class assumes that all JSON Schemas used by the system is stored in the Schema directory. (app/Schema). So whenever you have to define a new JSON Schema, save the JSON Schema file in the app/Schema Directory.

Each JSON Schema file is referenced using an alias. This alias is defined in the app/Schema/schema.php file.

Example,

```
trait Schema {
    private static $schema_model_array = array('Register' => 'Register.json',
                                             'Address' => 'UserAddress.json'
                                                );
    public static function getSchemaName($schema_name)
    {
        return $schema_name != NULL ? self::$schema_model_array[$schema_name] : NULL ;
    }
}
```

This trait as a dictionary for JSON Schema, allowing the the JSON Schema to be called anywhere within the Laravel app.

Also, the file app/Schema/schema.php, is made globally available in Laravel through composer.json
```
"autoload": {
    "classmap": [
      "database"
    ],
    "psr-4": {
      "App\\": "app/"
    },
    "files": [
      "app/Schema/schema.php"
    ]
  }
```
(Adding the schema file within the autoload)


Online tool to generate JSON Schema from a sample JSON (JSON Stubs) : http://jsonschema.net/
