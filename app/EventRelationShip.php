<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventRelationShip extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'event_id'
    ];

    public $timestamps = false;

    public function events(){
        return $this->belongsTo('App\Event', 'id' , 'event_id');
    }

}
