<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function toMe()
    {
        return view('expenses.to-me');
    }
    
    public function toAll()
    {
        return view('expenses.to-all');
    }
}
