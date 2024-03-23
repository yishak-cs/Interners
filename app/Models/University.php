<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class University extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'head_id', 'name', 'description'
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

        static::deleted(function ($university) {
            $university->departments()->get()->each->delete();
        });
    }

    /**
     * Get the user that mange the university
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function head(): BelongsTo
    {
        return $this->belongsTo(User::class, 'head_id', 'id')->withTrashed();
    }
    /**
     * Get all of the user for the university
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user(): HasMany
    {
        return $this->hasMany(User::class, 'university_id', 'id');
    }
    /**
     * Get all of the departments for the University
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class, 'university_id', 'id');
    }

    /**
     * Get University Admin name
     *
     * @return string
     */
    public function getHeadName(): string
    {
        if (!empty($this->head)) {
            return $this->head->getName();
        }

        return 'Not Assigned Yet';
    }
}
