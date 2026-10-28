<?php

namespace ComBank\OverdraftStrategy;

use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:39 PM
 */

/**
 * @description: Grant 100.00 overdraft funds.
 * */
class SilverOverdraft implements OverdraftInterface
{

      public function isGrantOverdraftFunds(float $amount): bool
      {

            $result = $amount + $this->getOverdraftFundsAmount();

            if ($result >= 0.0) {
                  return true;
            }

            return false;
      }

      public function getOverdraftFundsAmount(): float
      {

            return 100.0;
      }
}
