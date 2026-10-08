<?php namespace ComBank\Bank;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:25 PM
 */

use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\InvalidArgsException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\OverdraftStrategy\NoOverdraft;
use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;
use ComBank\Support\Traits\AmountValidationTrait;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class BankAccount
{
    private float $balance;
    private bool $status;
    public function __construct(float $balance = 0.0) {
        $this->balance = $balance;
        $this->status = true;
    }

    /**
     * Get the value of balance
     */ 
    public function getBalance()
    {
        return $this->balance;
    }

    public function closeAcount(){
        return $this-> status = false;
    }

    public function reopenAcount(){
        return $this-> status = true;
    }

    public function transaction(BankTransactionInterface)
    {

    }
    
    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }
    }
