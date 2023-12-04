<?php
namespace App\Models;

class Constants 
{
    const PENCE_TO_POUNDS= 100;

    const TRANSACTION_TYPE_CREDIT = 'credit';
    const TRANSACTION_TYPE_DEBIT = 'debit';
    const TRANSACTION_CATEGORY_FUND_WALLET = 'fund wallet';
    const TRANSACTION_CATEGORY_WITHDRAWAL = 'withdrawal';
    const TRANSACTION_CATEGORY_RESERVATION = 'reservation';
    const TRANSACTION_CATEGORY_ORDER = 'order';
    const TRANSACTION_CATEGORY_FEES = 'fees';

    const TRANSACTION_STATUS_COMPLETE = 'complete';
    const TRANSACTION_STATUS_PENDING = 'pending';
    const TRANSACTION_STATUS_CANCELLED = 'cancelled';

    

    
}