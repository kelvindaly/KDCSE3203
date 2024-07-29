<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'pickup_request_id', 'zone_id', 'priority_id', 'size_id', 'recipient_name',
        'recipient_address', 'recipient_email', 'recipient_phone', 'cost', 'status','driver_id',
    ];


    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function priority()
    {
        return $this->belongsTo(PackagePriority::class);
    }

    public function size()
    {
        return $this->belongsTo(PackageSize::class);
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function pickupRequest()
{
    return $this->belongsTo(PickupRequest::class);
}
}
