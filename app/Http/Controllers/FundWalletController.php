<?php

namespace App\Http\Controllers;

use App\Models\Constants;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\TransactionStatus;
use Illuminate\Support\Facades\DB;
use App\Models\TransactionCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostFundWallet;
use Illuminate\Http\RedirectResponse;

class FundWalletController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response|View
    {
        return view ('fund-wallet.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostFundWallet $request): RedirectResponse
    {
       DB::beginTransaction();
       
       try {
        
        $user = Auth::user();
        $data = $request->only('amount');
        $category = TransactionCategory::where('name', Constants::TRANSACTION_CATEGORY_FUND_WALLET)->first();
        $status = TransactionStatus::where('name', Constants::TRANSACTION_STATUS_PENDING)->first();
        $wallet = $user->wallet;
        $payeeBalanceBefore = $wallet->balance;

        $data = array_merge($data, [
            'transaction_category_id' => $category->id,
            'transaction_status_id' => $status->id,
            'payee_balance_before' => $payeeBalanceBefore,
            'payee_id' => $user->id,
            
        ]);

        $transaction = Transaction::create($data);
        //Update the wallet
        $penceAmount = $wallet->convertToPence($data['amount']);
        $wallet->increment('balance', $penceAmount);

        //Update the Status
        $status = TransactionStatus::where('name', Constants::TRANSACTION_STATUS_COMPLETE)->first();
        $payeeBalanceAfter = $wallet->balance;
        $data = [
            'transaction_status_id' => $status->id,
            'payee_balance_after' => $payeeBalanceAfter,
        ];
        $transaction->update($data);

        DB::commit();

        return redirect(route('transactions.index'))->with([
            'status' => 'Wallet Funded Successfully'
        ]);
       } catch (\Throwable $th) {
        DB::rollBack();
        throw $th;

       }
    }
}
