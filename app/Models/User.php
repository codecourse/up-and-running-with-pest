<?php

namespace App\Models;

use App\Models\Pivot\BookUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use Staudenmeir\LaravelMergedRelations\Eloquent\HasMergedRelationships;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasMergedRelationships;
    use HasRelationships;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function books()
    {
        return $this->belongsToMany(Book::class)
            ->using(BookUser::class)
            ->withPivot('status')
            ->withTimestamps();
    }

    public function addFriend(User $friend)
    {
        $this->friendsOfMine()->syncWithoutDetaching($friend, [
            'accepted' => false
        ]);
    }

    public function acceptFriend(User $friend)
    {
        $friend->friendsOfMine()->updateExistingPivot($this->id, [
            'accepted' => true
        ]);
    }

    public function removeFriend(User $friend)
    {
        $this->friendsOfMine()->detach($friend);
        $this->friendsOf()->detach($friend);
    }

    public function pendingFriendsOfMine()
    {
        return $this->friendsOfMine()->wherePivot('accepted', false);
    }

    public function acceptedFriendsOfMine()
    {
        return $this->friendsOfMine()->wherePivot('accepted', true);
    }

    public function acceptedFriendsOf()
    {
        return $this->friendsOf()->wherePivot('accepted', true);
    }

    public function pendingFriendsOf()
    {
        return $this->friendsOf()->wherePivot('accepted', false);
    }

    public function friendsOfMine()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
            ->withPivot('accepted', 'updated_at');
    }

    public function friendsOf()
    {
        return $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id')
            ->withPivot('accepted');
    }

    public function friends()
    {
        return $this->mergedRelationWithModel(User::class, 'friends_view');
    }

    public function booksOfFriends()
    {
        return $this->hasManyDeepFromRelations($this->friends(), (new User)->books())
            ->withIntermediate(BookUser::class)
            ->orderBy('__book_user__updated_at', 'desc');
    }
}
