<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';

    protected $fillable = [
        'name',
        'code',
        'vat_code',
        'address',
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
}