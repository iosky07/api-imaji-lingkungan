<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WasteBank;
use App\Models\WasteDeposit;

class UserController extends Controller
{
    public function index($id)
    {
        return view('pages.user.index', [
            'user' => User::class,
            'dataId' => WasteBank::find($id)
        ]);
    }

    public function show($id)
    {
        $wasteDeposit = User::find($id);
        return view('pages.user.show', compact('wasteDeposit'));
    }

    public function recap($id)
    {
        $users = User::whereWasteBankId($id)->get();
        foreach ($users as $user) {
            foreach ($user->wasteDeposits as $wd) {
                if ($wd->total == null) {
                    $total = 0;
                    foreach ($wd->wasteDepositDetails as $wdd) {
                        $total += $wdd->amount * $wdd->wasteType->price;
                    }
                    WasteDeposit::find($wd->id)->update(['total' => $total]);
                }
            }
        }
        return redirect(route('admin.user',$id));
    }
}
