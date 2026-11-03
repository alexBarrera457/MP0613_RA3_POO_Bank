<?php

namespace ComBank\Bank;

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
use ComBank\Transactions\BaseTransaction;
use ComBank\Transactions\Contracts\BankTransactionInterface;
use Override;

class BankAccount implements BankAccountInterface
{
    private float $balance;
    private bool $status;
    private $overdraft;
    private string $email;

    use AmountValidationTrait;


    public function __construct(float $balance = 0.0, string $email = "test@gmail.com")
    {
        $this->validateEmail($email);
        $this->balance = $balance;
        $this->status = true;
        $this->overdraft = new NoOverdraft();
        $this->email = $email;
    }

    public function transaction(BankTransactionInterface $bankTransaction): void
    {
        if (!$this->isOpen()) {
            throw new BankAccountException();
        }
        $newBalance = $bankTransaction->applyTransaction($this);
        $this->setBalance($newBalance);
    }


    public function isOpen(): bool
    {
        return $this->status;
    }

    public function closeAccount()
    {
        return $this->status = false;
    }

    public function reopenAccount()
    {
        if ($this->isOpen()) {

            throw new BankAccountException();
        }
        return $this->status = true;
    }
    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of balance
     *
     * @return  self
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * Get the value of balance
     */
    public function getBalance()
    {
        return $this->balance;
    }

    public function applyOverdraft(OverdraftInterface $overdraft)
    {
        return $this->overdraft = $overdraft;
    }

    /**
     * Get the value of overdraft
     */
    public function getOverdraft()
    {
        return $this->overdraft;
    }
    /**
     * Get the value of email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
}
