<?php
/**
 * This Software is part of aryelgois/databases and is provided "as is".
 *
 * @see LICENSE
 */

namespace aryelgois\Databases\Models\Address;

use aryelgois\Medools;

/**
 * A State contains counties
 *
 * @author Aryel Mota Góis
 * @license MIT
 * @link https://www.github.com/aryelgois/databases
 */
class State extends Medools\Model
{
    const DATABASE = 'address';

    const TABLE = 'states';

    const COLUMNS = ['id', 'country', 'code', 'name'];

    const FOREIGN_KEYS = [
        'country' => [
            Country::class,
            'id'
        ],
    ];

    const READ_ONLY = true;
}
