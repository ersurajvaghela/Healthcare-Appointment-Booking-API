<?php

namespace App\Http\Traits\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait RequestTraits {

    /**
     * Returns validations errors.
     *
     * @param Validator $validator
     * @throws  HttpResponseException
     */
    public function failedValidation(Validator $validator) {
        if ($this->wantsJson() || $this->ajax()) {
            throw new HttpResponseException($this->responseJson($validator->errors()));
        }
//        parent::failedValidation($validator);
    }

    /**
     * @param type $body
     * @param type $message
     * @param type $code
     * @param type $status
     * @return type
     */
    private function responseJson($errors, $message = "VALIDATOR") {
        if (!empty($errorMsgs = $errors->toArray())) {
            $firstKey = array_key_first($errorMsgs);
            $firstValueArray = $errorMsgs[$firstKey] ?? [];
            if (!empty($firstValueArray[0])) {
                $message = $firstValueArray[0];
                $body = $this->setErrorMessages($errorMsgs);
            }
        }
        return response()->json(['code' => BAD_REQUEST, 'message' => $message, 'body' => (object) [], 'errors' => (object) $body], VALIDATOR);
    }

    /**
     * @param type $errorMsgs
     * @return type
     */
    private function setErrorMessages($errorMsgs) {
        $ar = [];
        foreach ($errorMsgs as $key => $value) {
            $ar[$key] = implode(",", $value);
        }
        return $ar;
    }

}
