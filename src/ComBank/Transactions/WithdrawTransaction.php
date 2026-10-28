<?php

namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:22 PM
 */

use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Support\Traits\AmountValidationTrait;
use ComBank\Transactions\Contracts\BankTransactionInterface;
use Override;

class WithdrawTransaction extends BaseTransaction implements BankTransactionInterface
{
    use AmountValidationTrait;

    public function __construct($amount)
    {
        $this->validateAmount($amount);
        $this->amount = $amount;
    }

    #[Override]
    public function applyTransaction(BankAccountInterface $account): float
    {

        $verify = $account->getOverdraft()->isGrantOverdraftFunds($account->getBalance() - $this->amount);
        $verify2 = $account->getOverdraft();

        if ($verify) {
            return $account->getBalance() - $this->amount;
        }
        if ($verify2->getOverdraftFundsAmount() == 0) {
            throw new InvalidOverdraftFundsException;
        }
        throw new FailedTransactionException();
    }

    public function getTransactionInfo(): string
    {

        return "WITHDRAW_TRANSACTION";
    }
    /**
     * Get the value of amount
     */
    public function getAmount(): float
    {

        return $this->amount;
    }
}
