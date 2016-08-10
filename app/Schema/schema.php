<?php

trait Schema {
    private static $schema_model_array = array('Patient' => 'Patient.json',
                                             'Practitioner' => 'Practitioner.json',
                                             'Location' => 'Location.json',
                                             'Organization' => 'Organization.json',
                                             'Observation' => 'Observation.json',
                                             'DocumentReference' => 'DocumentReference.json',
                                             'ValueSet' => 'ValueSet.json',
                                             'Immunization' => 'Immunization.json',
                                             'CarePlan' => 'CarePlan.json',
                                             'Schedule' => 'Schedule.json',
                                             'Appointment' => 'Appointment.json',
                                             'Bundle' => 'Bundle.json',
                                             'Login' => 'Login.json',
                                             'Register' => 'Register.json'
                                                );
    public static function getSchemaName($schema_name)
    {
        return $schemaName != NULL ? self::$schema_model_array[$schema_name] : NULL ;
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
