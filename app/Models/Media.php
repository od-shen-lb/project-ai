<?php

namespace App\Models;

use App\Enums\AgentStatusEnum;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

class Media extends BaseMedia
{
    protected $fillable = [
        'model_type',
        'model_id',
        'collection_name',
        'name',
        'file_name',
        'mime_type',
        'disk',
        'size',
        'manipulations',
        'custom_properties',
        'generated_conversions',
        'responsive_images',
        'order_column',
        'admin_id',
        'status',
        'processed_at',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return AgentStatusEnum::from($this->status)->label();
    }

    protected static function booted(): void
    {
        static::saving(function ($media) {
            $media->admin_id = auth()->id();
        });
    }
}
