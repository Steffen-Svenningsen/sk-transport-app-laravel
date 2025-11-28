<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class InvoiceSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'address',
        'zip',
        'city',
        'cvr_number',
        'phone',
        'email',
        'bank_name',
        'reg_number',
        'account_number',
        'logo_path',
    ];

    protected static function booted(): void
    {
        static::updating(function (InvoiceSetting $setting) {
            if ($setting->isDirty('logo_path') && $setting->getOriginal('logo_path')) {
                Storage::disk('public')->delete($setting->getOriginal('logo_path'));
            }
        });

        static::deleting(function (InvoiceSetting $setting) {
            if ($setting->logo_path) {
                Storage::disk('public')->delete($setting->logo_path);
            }
        });
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo_path ? asset('storage/'.$this->logo_path) : null;
    }
}
