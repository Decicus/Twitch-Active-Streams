<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\StreamProfile;

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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['_id', 'bio', 'last_game', 'last_stream'];

    /**
     * The attributes that are hidden.
     *
     * @var array
     */
    protected $hidden = ['id', 'deleted_at'];

    /**
     * Retrieves only a stream profile based on their Twitch user ID
     *
     * @param int $id Twitch user ID
     * @return App\StreamProfile
     */
    public function findById($id)
    {
        return $this::where(['_id' => $id])->first();
    }

    /**
     * Finds a soft-deleted stream profile based on their Twitch user ID
     *
     * @param  int $id Twitch user ID
     * @return App\StreamProfile
     */
    public function findTrashed($id)
    {
        return $this::where(['_id' => $id])->onlyTrashed()->first();
    }

    /**
     * Retrieves or creates a stream profile based on their Twitch user ID.
     *
     * @param  int  $id The Twitch user ID
     * @return App\StreamProfile
     */
    public function findOrCreateProfile($id)
    {
        if ($profile = StreamProfile::withTrashed()->where(['_id' => $id])->first()) {
            return $profile;
        }

        return StreamProfile::create([
            '_id' => $id,
            'bio' => null,
            'last_game' => null,
            'last_stream' => null
        ]);
    }

    /**
     * Get the user connected to the profile.
     *
     * @return App\User
     */
    public function user()
    {
        return $this->belongsTo('App\User', '_id', '_id');
    }
}
