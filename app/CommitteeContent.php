<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommitteeContent extends Model
{
    public $fillable = ['title', 'description'];

    public $table = 'committee_contents';

    /**
     * @return BelongsTo
     */
    public function committee()
    {
        return $this->belongsTo(Committee::class);
    }
}