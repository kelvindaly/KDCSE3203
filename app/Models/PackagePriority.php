<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackagePriority extends Model
{
    use HasFactory;

    protected $fillable = ['priority_name', 'priority_rate'];
}
