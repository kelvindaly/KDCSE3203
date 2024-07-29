<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

User::create([
    'name' => 'Kelvin Daly',
    'email' => 'kelvindaly@gmail.com',
    'telephone' => '6001239',
    'role' => 'manager',
    'password' => Hash::make('password'), // Use a secure password
]);
