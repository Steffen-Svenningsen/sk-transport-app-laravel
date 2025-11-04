<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'task_type_id',
        'area_id',
        'grave_id',
        'service_id',
        'customer_id',
        'user_id',
        'work_type_id',
        'work_date',
        'hours',
        'break_hours',
        'comment',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'task_type_id' => 'integer',
            'area_id' => 'integer',
            'grave_id' => 'integer',
            'service_id' => 'integer',
            'customer_id' => 'integer',
            'user_id' => 'integer',
            'work_type_id' => 'integer',
            'work_date' => 'datetime',
            'hours' => 'decimal:2',
            'break_hours' => 'decimal:2',
        ];
    }

    public function taskType(): BelongsTo
    {
        return $this->belongsTo(TaskType::class);
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function grave(): BelongsTo
    {
        return $this->belongsTo(Grave::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function workType(): BelongsTo
    {
        return $this->belongsTo(WorkType::class);
    }
}
