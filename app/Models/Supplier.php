<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';

    protected $fillable = [
        'company_name',
        'company_code',
        'company_vat_number',
        'company_address',
        'responsible_person',
        'contact_person',
        'contact_phone',
        'alternate_contact_phone',
        'email',
        'alternate_email',
        'billing_email',
        'alternate_billing_email',
        'certificate_code',
        'is_fsc',
        'validation_date',
        'expiry_date',
        'comments',
    ];

    protected $casts = [
        'validation_date' => 'datetime',
        'expiry_date' => 'datetime',
    ];

    public $timestamps = true;

    protected function validationDate(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->toDateTimeString(),
        );
    }

    protected function expiryDate(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->toDateTimeString(),
        );
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->toDateTimeString(),
        );
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->toDateTimeString(),
        );
    }
}
