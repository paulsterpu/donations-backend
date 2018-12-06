<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function donationOffers() {
        return $this->belongsToMany(DonationOffer::class);
    }

    public function donationRequests() {
        return $this->belongsToMany(DonationRequest::class);
    }
}
