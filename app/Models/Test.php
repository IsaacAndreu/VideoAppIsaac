<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Test extends Model
{
    use HasFactory;

    protected $fillable = ['video_id', 'user_id'];

    /**
     * @return BelongsTo<Video, Test>
     */
    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }

    /**
     * @return BelongsTo<User, Test>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

