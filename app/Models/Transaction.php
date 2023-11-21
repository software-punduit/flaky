<?php

namespace App\Models;

use App\Traits\ConvertsDenominations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, ConvertsDenominations;

    protected $fillable = [
        'payer_id',
        'payee_id',
        'transaction_category_id',
        'transaction_status_id',
        'amount',
        'payee_balance_before',
        'payee_balance_after',
        'payer_balance_before',
        'payer_balance_after'
    ];

    protected function amount(): Attribute
    {
        return $this->convertDenomination();
    }
    protected function payeeBalanceBefore(): Attribute
    {
        return $this->convertDenomination();
    }
    protected function payeeBalanceAfter(): Attribute
    {
        return $this->convertDenomination();
    }
    protected function payerBalanceBefore(): Attribute
    {
        return $this->convertDenomination();
    }
    protected function payerBalanceAfter(): Attribute
    {
        return $this->convertDenomination();
    }

    /**
     * Get the payee that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payee_id');
    }

    /**
     * Get the payer that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payer_id');
    }

    /**
     * Get the transactionCategory that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transactionCategory(): BelongsTo
    {
        return $this->belongsTo(TransactionCategory::class);
    }

    /**
     * Get the transactionStatus that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transactionStatus(): BelongsTo
    {
        return $this->belongsTo(TransactionStatus::class);
    }

}
