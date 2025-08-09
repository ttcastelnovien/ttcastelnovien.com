<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\LicenceCategory;
use App\Enums\LicenceType;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Licence extends Pivot
{
    protected $table = 'licences';

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    /** @var list<string> */
    protected $fillable = [
        'licence_type',
        'needs_image_rights',
        'needs_exit_authorization',
        'needs_care_authorization',
        'needs_transport_authorization',
        'needs_medical_certificate',
        'has_image_rights',
        'has_exit_authorization',
        'has_care_authorization',
        'has_transport_authorization',
        'has_medical_certificate',
        'has_health_declaration',
        'doctor_name',
        'doctor_identifier',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'licence_type' => LicenceType::class,
            'needs_image_rights' => 'boolean',
            'needs_exit_authorization' => 'boolean',
            'needs_care_authorization' => 'boolean',
            'needs_transport_authorization' => 'boolean',
            'needs_medical_certificate' => 'boolean',
            'has_image_rights' => 'boolean',
            'has_exit_authorization' => 'boolean',
            'has_care_authorization' => 'boolean',
            'has_transport_authorization' => 'boolean',
            'has_medical_certificate' => 'boolean',
            'has_health_declaration' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function fullName(): string
    {
        return $this->person->fullName();
    }

    public function category(): LicenceCategory
    {
        return LicenceCategory::fromBirthDate($this->birth_date);
    }
}
