<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Product Model
 * @author IR Salvador
 * @since 2023.07.25
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price'];
}

