<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class VisitsUrls extends Model
{
    use HasFactory;
    protected $table = 'visits_urls';
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    /**
     * The booting method of the model.
     */
    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    protected $fillable = [
        'uuid',
        'url_id',
        'user_ip',
        'user_agent',
    ];

    /**
     * Get url of visit
     */
    public function url()
    {
        return $this->belongsTo(Urls::class, 'url_id', 'uuid');
    }
}
