<?php

namespace App\Http\Controllers;

class ContractController extends Controller
{
    public function show($id)
    {
        return view('contract.show', ['contractId' => $id]);
    }
}
