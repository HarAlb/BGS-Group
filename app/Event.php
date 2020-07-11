<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','slug','description','creator_id','creator_name', 'feature' , 'event_start' ,'event_end'
    ];

    public function Relation()
    {
        return $this->hasMany('App\EventRelationShip' , 'event_id' ,'id' );
    }

    public function AppliedUsers()
    {
        return  $this->hasManyThrough('App\User' ,'App\EventRelationShip' , 'event_id' , 'id' , 'id' , 'user_id');
    }
}
