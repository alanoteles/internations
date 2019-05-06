<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $page_items;


    public function __construct()
    {
        $this->page_items = 15;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param	string 		$model
     * @return 	array
     */
    public function getRules(string $model)
    {
        return config('app.validation_rules.'.$model);
    }



    /**
     * Validate the incoming request.
     *
     * @param  	array  	$data
     * @param	array	$data
     * @return 	\Illuminate\Contracts\Validation\Validator
     */
    protected function validatorInput(array $data, array $rules)
    {
        return Validator::make($data, $rules);
    }



    /**
     * Sanitise the incoming request.
     *
     * @param  	array  $data
     * @return 	\Illuminate\Contracts\Validation\Validator
     */
    protected function sanitizerInput(array $data)
    {
        $integers = [
            'user_id',
            'group_id',
        ];

        $floats = [
        ];

        $strings = [
            'name',
            'api_token',
        ];

        $booleans = [
            'admin',
        ];

        $emails = [
            'email',
        ];

        $urls = [
        ];

        $passwords = [
            'password',
            'password_confirmation',
        ];

        foreach ($data as $key => &$value) {
            if (is_array($value)) {
                $this->sanitizerInput($value);
            } else {
                if (in_array($key, $integers)) {
                    $value = filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
                } elseif (in_array($key, $strings)) {
                    $value = filter_var($value, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
                } elseif (in_array($key, $floats)) {
                    $value = filter_var($value, FILTER_VALIDATE_FLOAT);
                } elseif (in_array($key, $booleans)) {
                    $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                } elseif (in_array($key, $emails)) {
                    $value = filter_var($value, FILTER_VALIDATE_EMAIL);
                } elseif (in_array($key, $urls)) {
                    $value = filter_var($value, FILTER_VALIDATE_URL);
                } elseif (in_array($key, $passwords)) {
                    $value = strip_tags($value);
                }
            }
        }

        return $data;
    }
}
