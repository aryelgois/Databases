<?php
/**
 * This Software is part of aryelgois/databases and is provided "as is".
 *
 * @see LICENSE
 */

namespace aryelgois\Databases\Models\Address;

use aryelgois\Medools;

/**
 * A County is contained in a State, which is contained in a Country
 *
 * @author Aryel Mota Góis
 * @license MIT
 * @link https://www.github.com/aryelgois/databases
 */
class County extends Medools\Model
{
    const DATABASE = 'address';

    const TABLE = 'counties';

    const COLUMNS = ['id', 'state', 'name'];

    const FOREIGN_KEYS = [
        'state' => [
            State::class,
            'id'
        ],
    ];

    const READ_ONLY = true;
}
