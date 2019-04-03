<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class Introduction
 *
 * @method static Builder|Introduction whereYearId($value)
 * @mixin Eloquent
 * @method static Builder|Committee whereShortName($value)
 */
class Committee extends Model
{

    public $fillable = ['name', 'name_short', 'description'];

    public $table = 'committees';


    /**
     * @return HasMany
     */
    public function members()
    {
        return $this->hasMany(CommitteeMember::class);
    }

    /**
     * @return HasMany
     */
    public function owner()
    {
        return $this->hasMany(Member::class);
    }

    /**
     * @return HasMany
     */
    public function contents()
    {
        return $this->hasMany(CommitteeContent::class);
    }

}
