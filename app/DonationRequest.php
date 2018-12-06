<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DonationRequest extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }
}
