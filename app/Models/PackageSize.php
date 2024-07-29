<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageSize extends Model
{
    use HasFactory;

    protected $fillable = ['size_range', 'size_rate'];
}
