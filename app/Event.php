<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [];

    protected $table = 'events';

    protected $fillable = [
        'address', 'client' , 'name', 'start_date', 'end_date' , 'description', 'organizer', 'approved', 'public' , 'show_images',
    ];
    
    public function comments()
    { 
        return $this->hasMany(Comment::class);
    }

    public function eventImages()
    { 
        return $this->hasMany(EventImage::class);
    }

    //public function address()
    //{ 
    //    return $this->has(Address::class, 'address_id');
    //}

    //public function eventType()
    //{ 
    //    return $this->belongsTo(EventType::class, 'event_type_id');
    //}

    //public function menuType()
    //{ 
    //    return $this->belongsTo(MenuType::class, 'menu_type_id');
    //}
}
