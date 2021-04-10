<?php

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self pending()
 * @method static self approved()
 * @method static self refunded()
 * @method static self rejected()
 */

final class CancelOrderStatus extends Enum
{

}
