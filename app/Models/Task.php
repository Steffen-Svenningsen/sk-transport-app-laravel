<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

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
            'hours' => 'decimal:2',
            'break_hours' => 'decimal:2',
        ];
    }

    public function getActualTimeAttribute(): float
    {
        return $this->hours - $this->break_hours;
    }

    public function taskType(): BelongsTo
    {
        return $this->belongsTo(TaskType::class);
    }

    public function taskTypeWithTrashed(): BelongsTo
    {
        return $this->belongsTo(TaskType::class, 'task_type_id')->withTrashed();
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function areaWithTrashed(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_id')->withTrashed();
    }

    public function grave(): BelongsTo
    {
        return $this->belongsTo(Grave::class);
    }

    public function graveWithTrashed(): BelongsTo
    {
        return $this->belongsTo(Grave::class, 'grave_id')->withTrashed();
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function serviceWithTrashed(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id')->withTrashed();
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function customerWithTrashed(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id')->withTrashed();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function userWithTrashed(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function workType(): BelongsTo
    {
        return $this->belongsTo(WorkType::class);
    }

    public function workTypeWithTrashed(): BelongsTo
    {
        return $this->belongsTo(WorkType::class, 'work_type_id')->withTrashed();
    }
}
