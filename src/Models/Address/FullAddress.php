<?php
/**
 * This Software is part of aryelgois/databases and is provided "as is".
 *
 * @see LICENSE
 */

namespace aryelgois\Databases\Models\Address;

use aryelgois\Medools;

/**
 * A Full Address model to reference a specific place in the world
 *
 * This class expands the Address database to contain more specific information
 * about the address, which should be provided by your clients.
 *
 * It is not in the Address database because it is intended to be in your own
 * database, so foreign keys pointing to this model will be validated in the
 * Database
 *
 * @author Aryel Mota Góis
 * @license MIT
 * @link https://www.github.com/aryelgois/databases
 */
class FullAddress extends Medools\Model
{
    const TABLE = 'full_addresses';

    const COLUMNS = [
        'id',
        'county',
        'neighborhood',
        'place',
        'number',
        'zipcode',
        'detail',
        'update'
    ];

    const OPTIONAL_COLUMNS = [
        'detail',
        'update',
    ];

    const FOREIGN_KEYS = [
        'county' => [
            __NAMESPACE__ . '\County',
            'id'
        ],
    ];
}
