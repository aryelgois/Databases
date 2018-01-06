<?php
/**
 * This Software is part of aryelgois/databases and is provided "as is".
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
 * @link https://www.github.com/aryelgois/databases
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

        $count = count($this->data['states']);
        $states_sql = "-- $count State" . ($count > 1 ? 's' : '') . ":\n\n"
            . self::generateChunks(
                'INSERT INTO `states` (`id`, `country`, `code`, `name`) VALUES',
                $states
            );

        $counties_sql = '';
        foreach ($counties as $id => $block) {
            $counties_sql .= "-- $state_names[$id]\n\n"
                . self::generateChunks(
                    'INSERT INTO `counties` (`id`, `state`, `name`) VALUES',
                    $block
                );
        }

        return $states_sql . $counties_sql;
    }

    /**
     * Generates chunks of entries with the same statement
     *
     * @param string   $stmt    SQL statement
     * @param string[] $entries Entries to work on
     *
     * @return string
     */
    protected function generateChunks(string $stmt, array $entries)
    {
        $result = '';
        foreach (array_chunk($entries, self::CHUNK_SIZE) as $chunk) {
            $result .= $stmt . "\n"
                . implode("\n", Utils::arrayAppendLast($chunk, ";\n\n", ','));
        }
        return $result;
    }
}
