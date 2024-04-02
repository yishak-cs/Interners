<?php

namespace App\Models;

use App\Models\Department;
use App\Models\EvaluationResponse;
use App\Models\EvaluationTemplate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evaluation extends Model
{
    use HasFactory, SoftDeletes, HelperTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'department_id',
        'title',
        'body',
        'description',
        'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'body' => 'array'
    ];

    /**
     * Get all Evaluation Responses for this Evaluation
     *
     * @return HasMany
     */
    public function responses(): HasMany
    {
        return $this->hasMany(EvaluationResponse::class, 'evaluation_id');
    }

    /**
     * Get the Department that owns this Evaluation
     *
     * @return BelongsTo
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    
    /**
     * Get status of Evaluation in string form
     *
     * @return string
     */
    public function getStrStatusAttribute(): string
    {
        $str = ['inactive', 'active'];
        return $str[(int) $this->status];
    }
}
