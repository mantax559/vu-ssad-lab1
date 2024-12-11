<?php

namespace App\Http\Requests;

use App\Models\Supplier;
use Illuminate\Foundation\Http\FormRequest;
use Mantax559\LaravelHelpers\Helpers\RedirectHelper;
use Mantax559\LaravelHelpers\Helpers\TableHelper;
use Mantax559\LaravelHelpers\Helpers\ValidationHelper;

class SupplierUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'action' => ValidationHelper::getInArrayRules(values: [RedirectHelper::SaveAndStay, RedirectHelper::SaveAndClose]),
            'company_name' => ValidationHelper::getStringRules(),
            'company_code' => ValidationHelper::mergeRules(
                ValidationHelper::getUniqueRules(table: TableHelper::getName(Supplier::class), ignore: $this->supplier),
                ValidationHelper::getStringRules(),
            ),
            'company_vat_number' => ValidationHelper::getStringRules(required: false),
            'company_address' => ValidationHelper::getStringRules(),
            'responsible_person' => ValidationHelper::getStringRules(),
            'contact_person' => ValidationHelper::getStringRules(),
            'contact_phone' => ValidationHelper::getStringRules(),
            'alternate_contact_phone' => ValidationHelper::getStringRules(required: false),
            'email' => ValidationHelper::getStringRules(),
            'alternate_email' => ValidationHelper::getStringRules(required: false),
            'billing_email' => ValidationHelper::getStringRules(),
            'alternate_billing_email' => ValidationHelper::getStringRules(required: false),
            'certificate_code' => ValidationHelper::getStringRules(),
            'is_fsc' => ValidationHelper::getBooleanRules(),
            'validation_date' => ValidationHelper::getDateRules(),
            'expiry_date' => ValidationHelper::getDateRules(),
            'comments' => ValidationHelper::getTextRules(required: false),
        ];
    }
}
