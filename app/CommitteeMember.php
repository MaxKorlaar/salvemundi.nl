<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommitteeMember extends Model
{
    public $table = 'committee_members';

    public $fillable = ['direction', 'image', 'personal_message'];

    /**
     * @return BelongsTo
     */
    public function committee()
    {
        return $this->belongsTo(Committee::class);
    }

    /**
     * @return BelongsTo
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
