<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'university_id', 'head_id', 'name', 'description', 'company_id'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * cache delete event to delete child models
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::deleted(function ($department) {
            $department->internships()->get()->each->delete();
        });
    }

    /**
     * Get all of the internships for the Department
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function internships(): HasMany
    {
        return $this->hasMany(Internship::class, 'department_id', 'id');
    }
    /**
     * Get all of the user for the Department
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user(): HasMany
    {
        return $this->hasMany(User::class, 'deparment_id', 'id');
    }
    /**
     * Get the university that owns the Department
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class, 'university_id', 'id')->withTrashed();
    }
    /**
     * Get the university that owns the Department
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id')->withTrashed();
    }

    /**
     * Get the user that mange the Department
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function head(): BelongsTo
    {
        return $this->belongsTo(User::class, 'head_id', 'id')->withTrashed();
    }

    /**
     * Get all Evaluations for this Department
     *
     * @return HasMany
     */
    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class, 'department_id');
    }

    /**
     * Get University Admin name
     *
     * @return string
     */
    public function getHeadName(): string
    {
        if(!empty($this->head)){
            return $this->head->getName();
        }

        return 'Not Assigned Yet';
    }
}
