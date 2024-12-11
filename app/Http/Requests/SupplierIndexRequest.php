<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Mantax559\LaravelHelpers\Helpers\ValidationHelper;

class SupplierIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'search' => ValidationHelper::getStringRules(required: false),
        ];
    }
}
