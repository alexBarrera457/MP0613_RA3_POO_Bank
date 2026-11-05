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
use ComBank\Transactions\BaseTransaction;

use Override;

class TransferTransaction extends BaseTransaction implements BankTransactionInterface
{

    private BankAccountInterface $destinationAccount;

    use AmountValidationTrait;


    public function __construct(float $amount, BankAccountInterface $destinationAccount)
    {
        parent::__construct($amount);
        $this->destinationAccount = $destinationAccount;
    }

    #[Override]
    public function applyTransaction(BankAccountInterface $account): float
    {

        $b = $account->getBalance();

        $opp = $b - $this->amount;

        $this->getDestinationAccount()->transaction(new DepositTransaction($this->amount));

        $account->getBalance() - $this->amount;

        return $opp;
    }


    public function getTransactionInfo(): string
    {

        return "TRANSFER_TRANSACTION";
    }
    /**
     * Get the value of amount
     */
    public function getAmount(): float
    {

        return $this->amount;
    }

    /**
     * Get the value of destinationAccount
     */
    public function getDestinationAccount()
    {
        return $this->destinationAccount;
    }

    /**
     * Set the value of destinationAccount
     *
     * @return  self
     */
    public function setDestinationAccount($destinationAccount)
    {
        $this->destinationAccount = $destinationAccount;

        return $this;
    }
}
