<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'contact',
        'transaction_log_id',
        'total_amount',
        'cash',
        'change',
        'ss_number',
        'or_number',
        'status',
        'reason',
        'branch_id',
    ];

    public function transactionLogs()
    {
        return $this->hasMany(TransactionLog::class, 'transaction_number', 'transaction_number');
    }
}
