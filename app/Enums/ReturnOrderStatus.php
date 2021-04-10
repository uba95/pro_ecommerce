<?php

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self pending()
 * @method static self approved()
 * @method static self shipped()
 * @method static self returned()
 * @method static self refunded()
 * @method static self rejected()
 */

final class ReturnOrderStatus extends Enum
{

}