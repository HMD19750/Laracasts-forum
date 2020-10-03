<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    protected $with = ['creator', 'channel'];

    protected $appends = ['isSubscribedTo'];



    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($thread) {

            $thread->replies->each(function ($reply) {
                $reply->delete();
            });
        });
    }



    /**
     * Return value: path of the thread
     */
    public function path()
    {
        return url('/threads') . '/' . $this->channel->slug . '/' . $this->id;
    }


    public function replies()
    {
        return $this->hasMany(Reply::class);
    }


    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }


    public function addReply($reply)
    {
        return $this->replies()->create($reply);
    }


    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()

        ]);
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where('user_id', $userId ?: auth()->id())
            ->delete();
    }


    public function subscriptions()
    {

        return $this->hasMany(Threadsubscription::class);
    }


    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }
}
