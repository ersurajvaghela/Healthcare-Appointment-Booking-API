<?php

namespace App\Http\Traits\Controllers;

trait BaseControllerTraits {

    /**
     * common error
     * @param type $ex
     * @return string $message
     */
    public function _exception($ex) {
        report($ex); // Log the exception for rollbar or other logging services
        $message = 'Error on line ' . $ex->getLine() . ' in ' . $ex->getFile() . ' : <b>' . $ex->getMessage();
        if (env('APP_ENV') == 'production') {
            unset($message);
            return $ex->getMessage();
        } else if (env('APP_ENV') == 'staging') {
            unset($message);
            return $ex->getMessage();
        } else {
            unset($ex);
            return $message;
        }
    }

    /**
     * 
     * @param type $body
     * @return type
     */
    public function responseData($body) {
        return $body;
    }

    /**
     * responseJson
     * @param  mixed $responseCode
     * @param  mixed $responseMessages
     * @param  mixed $responseData
     * @return void
     */
    public function responseJson($responseCode = 200, $responseMessages = "Successfully", $responseData = []) {
        return (array) ['code' => $responseCode, 'message' => $responseMessages, 'body' => $responseData];
    }

    /**
     * responseJsonValidator
     * @param type $errors
     * @param type $responseMessages
     * @param type $responseCode
     * @param type $responseData
     * @return type
     */
    public function responseJsonValidator($errors, $responseMessages = "errors", $responseCode = VALIDATOR, $responseData = []) {
        return (array) ['code' => $responseCode, 'message' => $responseMessages, 'body' => $responseData, 'errors' => $errors];
    }

    /**
     * errors
     * @param type $errors
     * @param type $message
     * @return type
     */
    public function errors($errors, $message = "VALIDATOR") {
        if (!empty($errorMsgs = $errors->toArray())) {
            $firstKey = array_key_first($errorMsgs);
            $firstValueArray = $errorMsgs[$firstKey] ?? [];
            if (!empty($firstValueArray[0])) {
                $message = $firstValueArray[0];
                $errors = $this->setErrorMessages($errorMsgs);
            }
        }
        return [$message, $errors];
    }

    /**
     * 
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
