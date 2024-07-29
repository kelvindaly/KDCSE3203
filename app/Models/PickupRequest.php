<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PickupRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'pickup_date', 'pickup_time', 'pickup_address', 'payment_preference', 'user_id', 'pickup_status',
    ];

    protected $casts = [
        'pickup_date' => 'date',
        'pickup_time' => 'datetime:H:i'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function packages()
    {
        return $this->hasMany(Package::class);
    }

 
    public function getFormattedPickupDateAttribute()
    {
        return Carbon::parse($this->pickup_date)->format('F j, Y');
    }


    public function setPickupAddressAttribute($value)
    {
        $this->attributes['pickup_address'] = ucwords(strtolower($value));
    }

    // Accessor for pickup_time if needed
    public function getFormattedPickupTimeAttribute()
    {
        return Carbon::parse($this->pickup_time)->format('H:i');
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    



}
