<?php

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self pending()
 * @method static self paid()
 * @method static self shipped()
 * @method static self delivered()
 * @method static self partiallyCanceled()
 * @method static self canceled()
 * @method static self returning()
 * @method static self partiallyReturned()
 * @method static self returned()
 */

final class OrderStatus extends Enum
{

}
