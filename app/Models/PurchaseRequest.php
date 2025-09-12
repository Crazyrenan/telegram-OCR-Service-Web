<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    use HasFactory;

    // Add this one line to tell the model which database to use
    protected $connection = 'mysql_application';

    protected $fillable = [
        'user_id',
        'item_name',
        'amount',
        'reason',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}