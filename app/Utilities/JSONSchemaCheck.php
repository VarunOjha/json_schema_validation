<?php

namespace App\Utilities;
use Schema;
use JsonSchema;

class JSONSchemaCheck
{
    
    /* Wrapper function for JSON Schema Check 
    1. Create the schema for the JSON
    2. Save the .json file of the schema, in the schema folder in app (app_path())
    3. Create the alias for the JSON Schema in  the helpers file
    4. Use the Alias to call the below function
    5. Need to an array having "status" variable within it.
    Example : $status = array();
    $status["status"] = 1 ;
    6. If $status["status"] == 1, the schema is Correct, if 0 it is incorrect  
    */
    
    
    public static function validate_json($requestJSON, $schema)
    {
        $check           = [];
        $check["status"] = 1;
        $check           = self::check_schema(json_decode($requestJSON, true), $check, $schema);
        return $check;
    }
    
    private static function check_schema($json_array, $status, $schema_model)
    {
        $schemaPath = app_path() . "/Schema/" . Schema::getSchemaName($schema_model);
        $validKey   = $schema_model . "_VALID";
        $schemaKey  = $schema_model . "_SCHEMA";
        
        $retriever = new \JsonSchema\Uri\UriRetriever;
        $json_schema    = $retriever->retrieve('file://' . realpath("$schemaPath"));
        $data      = json_decode(json_encode($json_array));
        
        $refResolver = new \JsonSchema\RefResolver($retriever);
        $refResolver->resolve($schema, 'file://' . __DIR__);
        
        // Validate
        $validator = new JsonSchema\Validator();
        $validator->check($data, $json_schema);
        
        if ($validator->isValid()) {
            $status["status"] = $status["status"] & true;
            if (isset($status[$validKey])) {
                if ($status[$validKey] == 1) {
                    $status[$schemaKey] = 1;
                    $status[$validKey]  = 1;
                } else {
                    return $status;
                }
            } else {
                $status[$schemaKey] = 1;
                $status[$validKey]  = 1;
            }
        } else {
            $status["status"] = $status["status"] & false;
            if (isset($status[$schemaKey])) {
                $cnt = count($status[$schemaKey]);
            } else {
                $cnt = 0;
            }
            
            foreach ($validator->getErrors() as $error) {
                $status[$schemaKey][$cnt]          = array();
                $status[$schemaKey][$cnt]['field'] = $error['property'];
                $status[$schemaKey][$cnt]['issue'] = $error['message'];
                $status[$validKey]                 = 0;
                $cnt++;
            }
        }
        return $status;
    }   
}
