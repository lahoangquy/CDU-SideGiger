<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = self::createSlug($model->title);
            return true;
        });
    }

    public function poster(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function offers(): HasMany
    {
        return $this->hasMany(ProjectOffer::class)->orderBy('created_at', 'DESC');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function contract(): HasOne
    {
        return $this->hasOne(ProjectContract::class);
    }

    public function feedback(): BelongsTo
    {
        return $this->belongsTo(ProjectContractFeedback::class, 'id', 'contract_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ProjectDocument::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ProjectMessage::class);
    }

    public function invite()
    {
        return $this->hasOne(Invite::class);
    }

    public function requestCompleted()
    {
        return $this->hasOne(RequestCompleted::class);
    }

    private static function createSlug($name)
    {
        $slug = \Str::slug($name);

        if (static::whereSlug($slug)->exists()) {
            $max = static::whereTitle($name)->latest('id')->skip(1)->value('slug');

            if (isset($max[-1]) && is_numeric($max[-1])) {
                return preg_replace_callback('/(\d+)$/', function ($matches) {
                    return $matches[1] + 1;
                }, $max);
            }
            return "{$slug}-2";
        }

        return $slug;
    }
}
