<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class AgentType extends Model
{
    protected $table = 'agent_types';

    protected $fillable = [
        'name',
        'description',
        'admin_id',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    protected static function booted(): void
    {
        static::creating(function ($type) {
            $type->admin_id = Auth::id();
        });
    }
}
