<?php

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:24 PM
 */

use ComBank\Bank\BankAccount;
use ComBank\OverdraftStrategy\SilverOverdraft;
use ComBank\Transactions\DepositTransaction;
use ComBank\Transactions\WithdrawTransaction;
use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidArgsException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\OverdraftStrategy\GoldOverdraft;
use ComBank\OverdraftStrategy\NoOverdraft;
use ComBank\Transactions\InterestTransaction;
use ComBank\Transactions\TransferTransaction;

require_once 'bootstrap.php';

/*
pl('--------- PR03 POO ENTREGA ---------');


//---[Bank account 1]---/
// create a new account1 with balance 400
$bankAccount1 = new BankAccount(400.0);

pl('--------- [Start testing bank account #1, No overdraft] --------');
try {
    // show balance account
    pl('My balance: ' . $bankAccount1->getBalance());

    // close account
    pl('Closing account' . $bankAccount1->closeAccount());
    // reopen account
    pl('Reopening account' . $bankAccount1->reopenAccount());
    // deposit +150 
    pl('Doing transaction deposit (+150) with current balance ' . $bankAccount1->getBalance());
    $bankAccount1->transaction(new DepositTransaction(150.0));
    pl('My new balance after deposit (+150) : ' . $bankAccount1->getBalance());

    // withdrawal -25
    pl('Doing transaction withdrawal (-25) with current balance ' . $bankAccount1->getBalance());
    $bankAccount1->transaction(new WithdrawTransaction(25.0));
    pl('My new balance after withdrawal (-25) : ' . $bankAccount1->getBalance());

    // withdrawal -600
    pl('Doing transaction withdrawal (-600) with current balance ' . $bankAccount1->getBalance());
    $bankAccount1->transaction(new WithdrawTransaction(600.0));
} catch (ZeroAmountException $e) {
    pl($e->getMessage());
} catch (BankAccountException $e) {
    pl($e->getMessage());
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
} catch (InvalidArgsException $e) {
    pl('Error validation email: ' . $e->getMessage());
}
pl('My balance after failed last transaction : ' . $bankAccount1->getBalance());

//---[Bank account 2]---/
pl('--------- [Start testing bank account #2, Silver overdraft (100.0 funds)] --------');

$bankAccount2 = new BankAccount(100.0);

$bankAccount2->applyOverdraft(new SilverOverdraft());

try {

    // show balance account
    pl('My balance: ' . $bankAccount2->getBalance());
    // deposit +100
    pl('Doing transaction deposit (+100) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new DepositTransaction(100.0));
    pl('My new balance after deposit (+100) : ' . $bankAccount2->getBalance());

    // withdrawal -300
    pl('Doing transaction deposit (-300) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(300.0));
    pl('My new balance after withdrawal (-300) : ' . $bankAccount2->getBalance());

    // withdrawal -50
    pl('Doing transaction deposit (-50) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(50.0));
    pl('My new balance after withdrawal (-50) with funds : ' . $bankAccount2->getBalance());

    // withdrawal -120
    pl('Doing transaction withdrawal (-120) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(120.0));
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
}
pl('My balance after failed last transaction : ' . $bankAccount2->getBalance());

try {
    pl('Doing transaction withdrawal (-20) with current balance : ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(20.0));
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
} catch (InvalidArgsException $e) {
    pl('Error validation email: ' . $e->getMessage());
}
pl('My new balance after withdrawal (-20) with funds : ' . $bankAccount2->getBalance());

try {
} catch (BankAccountException $e) {
    pl($e->getMessage());
}


pl('-----------------------------------------------------------------------------------------------------');

pl('--------- EXAMEN SIMULACRO 1 ---------');

//---[Bank account 3 with correct format email]---/

pl('--------- [Start testing bank account #3, account with correct format email] --------');
try {
    $bankAccount3 = new BankAccount(600.0, "john.smith@example.com");

    // show balance account
    pl('My balance: ' . $bankAccount3->getBalance());
    pl('My email: ' . $bankAccount3->getEmail());
} catch (InvalidArgsException $e) {
    pl('Error validation email: ' . $e->getMessage());
}

//---[Bank account 4 with incorrect format email]---/


pl('--------- [Start testing bank account #4, account with incorrect format email] --------');
try {
    $bankAccount4 = new BankAccount(600.0, "johnexample.com");


    // show balance account
    pl('My balance: ' . $bankAccount4->getBalance());
    pl('My email: ' . $bankAccount4->getEmail());
} catch (InvalidArgsException $e) {
    pl('Error validation email: ' . $e->getMessage());
}
pl('-----------------------------------------------------------------------------------------------------');

pl('--------- EXAMEN SIMULACRO 2 ---------');

//---[Bank account 5 (NoOverdraft with Interest)]---/

pl('--------- [Start testing bank account #5, No overdraft] --------');

$bankAccount5 = new BankAccount(10000.0, "nooverdraft@gmail.com");
$bankAccount5->applyOverdraft(new NoOverdraft());

try {
    pl('My balance: ' . $bankAccount5->getBalance());
    pl('My email: ' . $bankAccount5->getEmail());
    pl('Doing interest transaction with rate ' . $bankAccount5->getOverdraft()->getInterestRate() . '%');
    $bankAccount5->transaction(new InterestTransaction());
    pl('My new balance after interest : ' . $bankAccount5->getBalance());
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
} catch (BankAccountException $e) {
    pl($e->getMessage());
}


//---[Bank account 6 (SilverOverdraft with Interest)]---/

pl('--------- [Start testing bank account #6, Silver overdraft] --------');

$bankAccount6 = new BankAccount(10000.0, "silveroverdraft@gmail.com");
$bankAccount6->applyOverdraft(new SilverOverdraft());

try {
    pl('My balance: ' . $bankAccount6->getBalance());
    pl('My email: ' . $bankAccount6->getEmail());
    pl('Doing interest transaction with rate ' . $bankAccount6->getOverdraft()->getInterestRate() . '%');
    $bankAccount6->transaction(new InterestTransaction());
    pl('My new balance after interest : ' . $bankAccount6->getBalance());
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
} catch (BankAccountException $e) {
    pl($e->getMessage());
}



//---[Bank account 7 (Gold Overdraft with Interest)]---/

pl('--------- [Start testing bank account #7, Gold overdraft] --------');

$bankAccount7 = new BankAccount(10000.0, "goldoverdraft@gmail.com");
$bankAccount7->applyOverdraft(new GoldOverdraft());

try {
    pl('My balance: ' . $bankAccount7->getBalance());
    pl('My email: ' . $bankAccount7->getEmail());
    pl('Doing interest transaction with rate ' . $bankAccount7->getOverdraft()->getInterestRate() . '%');
    $bankAccount7->transaction(new InterestTransaction());
    pl('My new balance after interest : ' . $bankAccount7->getBalance());
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
} catch (BankAccountException $e) {
    pl($e->getMessage());
}
*/
pl('-----------------------------------------------------------------------------------------------------');
pl('--------- EXAMEN ---------');


//---[Bank account 8 (Transfer Transaction)]---/

pl('--------- [Start testing bank account #8, Transfer Transaction] --------');

$bankAccount1 = new BankAccount(500.0);
$bankAccount2 = new BankAccount(200.0);

pl('Source Account Balance: ' . $bankAccount1->getBalance());
pl('Destination Account Balance: ' . $bankAccount2->getBalance());

$bankAccount1->transaction(new TransferTransaction(100.0, $bankAccount2));

pl('Transfer Amount: ');

pl('Source Balance After Transaction: ' . $bankAccount1->getBalance());

pl('Destination Balance After Transaction: ' . $bankAccount2->getBalance());
