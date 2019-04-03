<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Committee extends Model
{

    public $fillable = ['name', 'description'];

    public $table = 'committees';


    /**
     * @return HasMany
     */
    public function members()
    {
        return $this->hasMany(CommitteeMember::class);
    }
}
