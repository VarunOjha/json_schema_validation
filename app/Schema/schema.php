<?php

trait Schema {
    private static $schema_model_array = array('Register' => 'Register.json',
                                             'Address' => 'UserAddress.json'
                                                );
    public static function getSchemaName($schema_name)
    {
        return $schema_name != NULL ? self::$schema_model_array[$schema_name] : NULL ;
    }
}

// Main helpers file to be used for everything possible
function convert_to_array($data)
{
    $result = json_decode(json_encode($data),true);
    return $result ;
}


function isJson($string)
{
    if (!is_string($string)) {
        return false;
    }

    $string = trim($string);
    $firstChar = substr($string, 0, 1);
    $lastChar = substr($string, -1);
    if (!$firstChar || !$lastChar) {
        return false;
    }
    if ($firstChar !== '{' && $firstChar !== '[') {
        return false;
    }
    if ($lastChar !== '}' && $lastChar !== ']') {
        return false;
    }
    json_decode($string);
    $isValid = json_last_error() === JSON_ERROR_NONE;
    return $isValid;
}
