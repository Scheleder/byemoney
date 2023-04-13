<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'creditor_id',
        'user_id',
        'mean_payment_id',
        'value',
        'due_date',
        'paid_date',
        'barcode',
        'paid',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'paid_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function creditor()
    {
        return $this->belongsTo(Creditor::class, 'creditor_id', 'id');
    }

    public function mean()
    {
        return $this->belongsTo(Creditor::class, 'mean_payment_id', 'id');
    }
}
