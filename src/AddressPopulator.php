<?php
/**
 * This Software is part of aryelgois/Databases and is provided "as is".
 *
 * @see LICENSE
 */

namespace aryelgois\Databases;

use aryelgois\YaSql\Populator;
use aryelgois\YaSql\Utils;

/**
 * Generates SQL to populate the Address database
 *
 * @author Aryel Mota Góis
 * @license MIT
 * @link https://www.github.com/aryelgois/Databases
 */
class AddressPopulator extends Populator
{
    /**
     * How many entries can are allowed in each INSERT INTO statement
     *
     * @const integer
     */
    const CHUNK_SIZE = 100;

    /**
     * Generates SQL to populate the Address table
     *
     * @return string
     */
    public function run()
    {
        $states = $state_names = $counties = [];
        $id_states = $id_counties = 0;

        foreach ($this->data['states'] as $state) {
            $states[] = sprintf(
                "(%s, %s, '%s', '%s')",
                ++$id_states,
                $this->data['country'],
                $state['code'],
                str_replace("'", "\\'", $state['name'])
            );
            foreach ($state['counties'] as $county) {
                $counties[$id_states][] = sprintf(
                    "(%s, %s, '%s')",
                    ++$id_counties,
                    $id_states,
                    str_replace("'", "\\'", $county)
                );
            }
            $state_names[$id_states] = $state['name'];
        }

        $states = array_chunk($states, self::CHUNK_SIZE);
        $states_sql = [];
        foreach ($states as $chunk) {
            $states_sql = array_merge(
                $states_sql,
                [
                    '',
                    'INSERT INTO `states` (`id`, `country`, `code`, `name`) VALUES',
                ],
                Utils::arrayAppendLast($chunk, ';', ',')
            );
        }

        $counties_sql = [];
        foreach ($counties as $id => $block) {
            $counties_sql = array_merge(
                $counties_sql,
                [
                    '',
                    '-- ' . $state_names[$id],
                ]
            );
            $chunks = array_chunk($block, self::CHUNK_SIZE);
            foreach ($chunks as $chunk) {
                $counties_sql = array_merge(
                    $counties_sql,
                    [
                        '',
                        'INSERT INTO `counties` (`id`, `state`, `name`) VALUES',
                    ],
                    Utils::arrayAppendLast($chunk, ';', ',')
                );
            }
        }

        $count = count($this->data['states']);

        return implode("\n", array_merge(
            ['-- ' . $count . ' State'. ($count > 1 ? 's' : '') . ':'],
            $states_sql,
            $counties_sql
        ));
    }
}
