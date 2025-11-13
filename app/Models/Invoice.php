<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'invoice_number',
        'customer_id',
        'issue_date',
        'invoice_title',
        'product_lines',
        'subtotal',
        'tax',
        'total',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'product_lines' => 'array',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getSubtotalAttribute($value)
    {
        if ($value) {
            return $value;
        }

        if (empty($this->lines)) {
            return 0;
        }

        return collect($this->lines)->sum(function ($line) {
            return ($line['quantity'] ?? 0) * ($line['unit_price'] ?? 0);
        });
    }

    public function getTaxAttribute($value)
    {
        return $value ?? ($this->subtotal * 0.25);
    }

    public function getTotalAttribute($value)
    {
        return $value ?? ($this->subtotal + $this->tax);
    }

    public function getPaymentDueDateAttribute()
    {
        return $this->issue_date->copy()->addDays(14);
    }

    public function getProductLinesForInfolistAttribute()
    {
        return collect($this->product_lines)->map(function ($line) {
            $service = $line['custom_service']
                ?? Service::find($line['service_id'])?->name
                ?? '-';

            return [
                'service_description' => $service,
                'quantity' => $line['quantity'] ?? 0,
                'unit_price' => $line['unit_price'] ?? 0,
                'total' => $line['total'] ?? 0,
            ];
        })->toArray();
    }

    public static function getNextInvoiceNumber(): string
    {
        $lastNumber = self::withTrashed()
            ->where('invoice_number', 'like', 'SKT-%')
            ->orderByDesc('id')
            ->first()
            ->invoice_number ?? 'SKT-00000';

        preg_match('/SKT-(\d+)/', $lastNumber, $matches);
        $nextNumber = (int) ($matches[1] ?? 0) + 1;

        return 'SKT-'.str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }

    public function customerWithTrashed()
    {
        return $this->belongsTo(Customer::class, 'customer_id')->withTrashed();
    }
}
