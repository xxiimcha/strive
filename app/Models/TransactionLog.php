<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_number',
        'or_number',
        'branch_id',
        'status',
        'reason',
        'item_name',
        'item_rate',
        'quantity',
        'staff_name',
        'ss_number',
    ];
}
