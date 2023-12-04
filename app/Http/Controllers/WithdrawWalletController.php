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
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\PostWithdrawWallet;

class WithdrawWalletController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response|View
    {
        return view('withdraw-wallet.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(PostWithdrawWallet $request): RedirectResponse
    {
        //validate the request
        //Get the data 
        //store the data
        
        $data = $request->only('amount');
        $user = Auth::user();
        $wallet = $user->wallet;
        $balance = $wallet->balance ?? 0;

        if ($balance < $request->amount) {
            return back()->withErrors(['amount' => 'Insufficient Balance'])->withInput();
        }
        DB::beginTransaction();

        try {
            if($balance >= $request->amount) {
                $category = TransactionCategory::where('name', Constants::TRANSACTION_CATEGORY_WITHDRAWAL)->first();
                $status = TransactionStatus::where('name',Constants::TRANSACTION_STATUS_PENDING)->first();

                $payerBalanceBefore = $wallet->balance;
            

                 $data = array_merge($data, [
                'transaction_category_id' => $category->id,
                'transaction_status_id' => $status->id,
                'payer_balance_before' => $payerBalanceBefore,
                'payer_id' => $user->id,

            ]);

            $transaction = Transaction::create($data);
            //Update the wallet
            $balance = $balance - $data['amount'];
            // $penceAmount = $wallet->convertToPence($data['amount']);
            $wallet->update(['balance' => $balance]);

            //Update the status
            $status = TransactionStatus::where('name', Constants::TRANSACTION_STATUS_COMPLETE)->first();

            $payerBalanceAfter = $wallet->balance;
            $data = [
                'transaction_status_id' => $status->id,
                'payer_balance_after' => $payerBalanceAfter,
            ];
            $transaction->update($data);

            DB::commit();

            return redirect(route('transactions.index'))->with([
                'status' => 'Withdrawal Successful'
            ]);
        }
        
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}

