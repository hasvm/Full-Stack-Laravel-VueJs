<?php

namespace App\Http\Controllers;

use App\Lib\WalletLogic;
use App\Models\Wallet;
use Symfony\Component\HttpFoundation\Request;

class WalletController extends Controller
{
    public function getWallet(Request $request, $id)
    {
        $wallet = Wallet::where('company_id', $id)->first();
        $value = WalletLogic::$COMPANY_CONTACTED_CANDIDATE;
        return ['wallet' => $wallet, 'value' => $value];
    }
}