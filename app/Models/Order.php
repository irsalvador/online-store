<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Order Model
 * @author IR Salvador
 * @since 2023.07.25
 */
class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'total_amount', 'order_details'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
