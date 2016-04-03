<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StreamProfile extends Model
{
    use SoftDeletes;

    /**
     * The associated table to this model.
     * 
     * @var string
     */
    protected $table = 'stream_profiles';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
