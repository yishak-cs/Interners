<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
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

        static::deleted(function ($company) {
            $company->departments()->get()->each->delete();
        });
    }

    /**
     * Get the user that mange the Company
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function head(): BelongsTo
    {
        return $this->belongsTo(User::class, 'head_id', 'id')->withTrashed();
    }

    /**
     * Get all of the departments for the company
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class, 'company_id', 'id');
    }
    /**
     * Get all of the internship for the Company
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function internship(): HasMany
    {
        return $this->hasMany(Internship::class, 'company_id', 'id');
    }

    /**
     * Get Company Admin name
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
