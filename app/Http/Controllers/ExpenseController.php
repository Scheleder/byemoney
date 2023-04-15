<?php

namespace App\Http\Controllers;

use App\Services\LogService;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\User;
use App\Models\Creditor;

class ExpenseController extends Controller
{
    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }

    public function create(Request $request)
    {
        try {
            $expense = new Expense;
            $expense->creditor_id = $request->creditor_id;
            $expense->description = $request->description;
            $cost = preg_replace('/[^\d\.\,]/', '', $request->value);
            $expense->value = str_replace(',', '.', $cost);
            $expense->due_date = $request->due_date;
            $expense->save();
        } catch (\Throwable $th) {
            notify()->error('Ocorreu um erro!');
            return redirect(url()->previous());
        }

        $this->logService->addLog(auth()->user()->id, auth()->user()->name.' adicionou a despesa '.$expense->description);
        notify()->success('Despesa adicionada!');
        return redirect(url()->previous());
    }

    public function toMe()
    {
        $expenses = Expense::where('paid', 0)->where('user_id', auth()->user()->id)->get()->sortBy('due_date');
        return view('expenses.to-me', [ 'expenses' => $expenses ]);
    }

    public function toAll()
    {
        $creditors = Creditor::all()->sortBy('name');
        $users = User::all()->sortBy('name');
        $expenses = Expense::where('paid', 0)->get()->sortBy('due_date');
        return view('expenses.to-all', [ 'expenses' => $expenses, 'users' => $users, 'creditors' => $creditors]);
    }

    public function attachUser($expense_id, $user_id)
    {
        $expense = Expense::findOrFail($expense_id);
        $expense->user_id = $user_id;
        $expense->save();
        $this->logService->addLog(auth()->user()->id, auth()->user()->name.' designou a despesa '.$expense->description);
        notify()->success('Despesa designada!');
        return redirect(url()->previous());
    }

    public function detachUser($expense_id)
    {
        $expense = Expense::findOrFail($expense_id);
        $expense->user_id = null;
        $expense->save();
        $this->logService->addLog(auth()->user()->id, auth()->user()->name.' rejeitou a despesa '.$expense->description);
        notify()->success('Despesa rejeitada!');
        return redirect(url()->previous());
    }
}
