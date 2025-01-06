<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Agent extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'agents';

    const string AGENT_FILES_COLLECTION = 'agent_files';

    protected $fillable = [
        'name',
        'type_id',
        'model_id',
        'is_enabled',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(AgentType::class);
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(AgentModel::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::deleting(function ($agent) {
            $agent->clearMediaCollection(self::AGENT_FILES_COLLECTION);
        });
    }

    protected static function booted(): void
    {
        static::saving(function ($agent) {
            $agent->admin_id = Auth::id();
        });
    }
}
