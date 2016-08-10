<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Utilities\JSONSchemaCheck as JSONValidator;
use App\Models\User as User;

class UserController extends Controller
{
	// Registering a user
    public function register(Request $request)
    {
        $result = $request->getContent();
        if (isJson($result) == FALSE) {
            $result = errorResponse("INVALID_JSON");
            return response()->json($result,422,[],JSON_NUMERIC_CHECK);  
        }
        
        $schemaCheck = JSONValidator::jsonSchemaValidate($result,'Register');
        if ($schemaCheck["status"] == 0) {
            $res                     = errorResponse("INVALID_JSON_SCHEMA");
            $res["error"]["details"] = $schemaCheck;
            return response()->json($res,422,[],JSON_NUMERIC_CHECK); 
        }
        return response()->json($result,201,[],JSON_NUMERIC_CHECK);
    }
}
