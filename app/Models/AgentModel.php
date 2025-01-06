<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class AgentModel extends Model
{
    protected $table = 'agent_models';

    protected $fillable = [
        'name',
        'admin_id',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    protected static function booted(): void
    {
        static::creating(function ($model) {
            $model->admin_id = Auth::id();
        });
    }
}
