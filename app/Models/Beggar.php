<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Beggar extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city',
        'bio',
        'photo',
        'unique_code',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function tips()
    {
        return $this->hasMany(Tip::class);
    }

    public function totalTips()
    {
        return $this->tips()->where('status', 'paid')->sum('amount');
    }

    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return asset('images/default-avatar.png');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->unique_code)) {
                $model->unique_code = strtoupper(Str::random(8));
            }
        });
    }
}
