<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Mantax559\LaravelHelpers\Helpers\RedirectHelper;
use Mantax559\LaravelHelpers\Helpers\ValidationHelper;

class SupplierStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'action' => ValidationHelper::getInArrayRules(values: [RedirectHelper::SaveAndStay, RedirectHelper::SaveAndClose]),
            'company_name' => ValidationHelper::getStringRules(),
            'company_code' => ValidationHelper::getStringRules(),
            'company_vat_number' => ValidationHelper::getStringRules(required: false),
            'company_address' => ValidationHelper::getStringRules(),
            'responsible_person' => ValidationHelper::getStringRules(),
            'contact_person' => ValidationHelper::getStringRules(),
            'contact_phone' => ValidationHelper::getStringRules(),
            'alternate_contact_phone' => ValidationHelper::getStringRules(required: false),
            'email' => ValidationHelper::getEmailRules(),
            'alternate_email' => ValidationHelper::getEmailRules(required: false),
            'billing_email' => ValidationHelper::getEmailRules(),
            'alternate_billing_email' => ValidationHelper::getEmailRules(required: false),
            'certificate_code' => ValidationHelper::getStringRules(),
            'is_fsc' => ValidationHelper::getBooleanRules(),
            'validation_date' => ValidationHelper::getDateRules(),
            'expiry_date' => ValidationHelper::getDateRules(),
            'comments' => ValidationHelper::getTextRules(required: false),
        ];
    }
}
