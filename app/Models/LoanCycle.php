<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanCycle extends Model
{
    use HasFactory;
    protected $fillable = [
        'repay_date', 'next_replay_date', 'amount_paid', 'loan_id'
    ];
}
