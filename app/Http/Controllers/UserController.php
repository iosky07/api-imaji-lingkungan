<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WasteBank;
use App\Models\WasteDeposit;

class UserController extends Controller
{
    public function index ($id)
    {
        return view('pages.user.index', [
            'user' => User::class,
            'dataId'=>WasteBank::find($id)
        ]);
    }
    public function show($id){
        $wasteDeposit = User::find($id);
        return view('pages.user.show', compact('wasteDeposit'));
    }
}
