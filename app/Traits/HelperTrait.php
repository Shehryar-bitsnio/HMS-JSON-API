<?php

namespace App\Traits;

use App\Models\Company;
use App\Models\User;
use DateTime;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Exceptions\JsonApiException;
use Throwable;

trait  HelperTrait{

    public function successResponse($data, $message = null, $code = 200, $token=null){
        return response()->json([
			'success'=> true,
			'message' => $message,
			'data' => $data,
            'token'=>$token
		], $code);
    }


    public function errorResponse($title = null, $detail, $code=400, $token=null){
        $error = Error::fromArray([
            'title' => $title,
            'detail' => $detail,
            'status' => $code,
        ]);

        throw new JsonApiException($error);
    }


    public function validationErrorsToString($errArray){
        $valArr = array();
        foreach ($errArray->toArray() as $key => $value) {
            $errStr = $key.':'.$value[0];
            array_push($valArr, $errStr);
        }
        if(!empty($valArr)){
            $errStrFinal = implode('<br>', $valArr);
        }
        return $errStrFinal;
    }

    public static function dayTimeToString($days = 0, $hours = 0, $minutes = 0) {
        $totalMinutes = $days * 24 * 60 + $hours * 60 + $minutes;

        if ($totalMinutes < 60) {
            // Rounding up minutes
            $result = "up to " . $totalMinutes . " minutes";
        } elseif ($totalMinutes < 24 * 60) {
            // Rounding up hours
            $totalHours = ceil($totalMinutes / 60);
            $result = "up to " . ceil($totalHours / 24) * 24 . " hours";
        } else {
            // Rounding up days
            $totalDays = ($totalMinutes / (24 * 60));
            $result = "up to " . ceil($totalDays) . " days";
        }

        return $result;
    }

    public function objectsToArray($objects, $additionalFields) {
        return array_map(function($object) use ($additionalFields) {
            // Convert the object to an associative array
            $array = (array) $object;
            // Merge additional fields with the array
            return array_merge($array, $additionalFields);
        }, $objects);
    }
}
