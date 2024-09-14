<?php

namespace App\Http\Requests;

use App\Http\Responses\ResponseBuilder;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class BaseRequest extends FormRequest{
    protected array $expectedParameters = [];

    public function prepareForValidation(){
        $parameters = $this->all();

        foreach($parameters as $parameter){
            $isExpected = in_array($parameter, $this->expectedParameters);

            if(!$isExpected){
                return response()->json("failed, unexpected parameter", 403);
            }
        }
    }

    protected function failedValidation(Validator $validator){
        $errorMessagesArray = $validator->errors()->getMessages();
        $formatedError = [];

        foreach($errorMessagesArray as $errorMessages){
            foreach($errorMessages as $error){
                array_push($formatedError, $error);
            }
        }
        $responseBuilder = new ResponseBuilder();
        $responseMessageObject = $responseBuilder->status(400, true, array_values($formatedError))->getMessageObject();

        throw (new ValidationException($validator, response()->json($responseMessageObject, 400)));
    }
}
