<?php
/**
 * This Software is part of aryelgois/databases and is provided "as is".
 *
 * @see LICENSE
 */

namespace aryelgois\Databases\Models\Address;

use aryelgois\Medools;

/**
 * A Country contains States which contain Counties
 *
 * @author Aryel Mota Góis
 * @license MIT
 * @link https://www.github.com/aryelgois/databases
 */
class Country extends Medools\Model
{
    const DATABASE_NAME_KEY = 'address';

    const TABLE = 'countries';

    const COLUMNS = [
        'id',
        'code_a2',
        'code_a3',
        'code_number',
        'name_en',
        'name_local'
    ];

    const READ_ONLY = true;
}
