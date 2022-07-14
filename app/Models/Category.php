<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = self::createSlug($model->name);
            return true;
        });
    }

    public function subs(): HasMany
    {
        return $this->hasMany(SubCategory::class, 'parent_id');
    }

    public function scopeActive($query, $active = 1)
    {
        return $query->where('active', $active);
    }

    private static function createSlug($name)
    {
        $slug = \Str::slug($name);

        if (static::whereSlug($slug)->exists()) {
            $max = static::whereName($name)->latest('id')->skip(1)->value('slug');

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
