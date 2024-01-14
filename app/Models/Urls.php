<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Urls extends Model
{
    use HasFactory;
    protected $table = 'urls';
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    /**
     * The booting method of the model.
     */
    protected static function boot(): void{
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    protected $fillable = [
        'uuid',
        'original_url',
        'short_url',
        'visits',
        'user_ip',
        'expires_at',
    ];

    /**
     * Get visits of url
     */
    public function visits()
    {
        return $this->hasMany(VisitsUrls::class, 'url_id', 'uuid');
    }
}
