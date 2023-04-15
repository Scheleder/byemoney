<?php

namespace App\Http\Controllers;

use App\Services\LogService;
use Illuminate\Http\Request;
use App\Models\Creditor;

class CreditorController extends Controller
{
    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }

    public function create(Request $request)
    {
        try {
            $creditor = new Creditor;
            $creditor->name = $request->name;
            $creditor->save();
        } catch (\Throwable $th) {
            notify()->error('Ocorreu um erro!');
            return redirect(url()->previous());
        }

        $this->logService->addLog(auth()->user()->id, auth()->user()->name.' adicionou o fornecedor '.$creditor->name);
        notify()->success('Fornecedor adicionado!');
        return redirect(url()->previous());
    }
}
