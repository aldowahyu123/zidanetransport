<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Service;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $primaryKey = 'service_id';
    protected $fillable = ['service_name', 'description', 'price_multiplier', 'vehicle_type', 'available_status'];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'service_id');
    }

    public function showBookingForm()
    {
    $services = Service::all(); // Ambil semua layanan
    return view('booking.form', compact('services'));
    }  

    public function vehicle()
{
    return $this->belongsTo(Vehicle::class);
}

}
