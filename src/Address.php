<?php
/**
 * This Software is part of aryelgois/Databases and is provided "as is".
 *
 * @see LICENSE
 */

namespace aryelgois\Databases;

use aryelgois\YaSql\Utils;
use Symfony\Component\Yaml\Yaml;

/**
 * Generates SQL to populate the Address database
 *
 * @author Aryel Mota Góis
 * @license MIT
 * @link https://www.github.com/aryelgois/Databases
 */
class Address
{
    /**
     * Path to YAML sources
     *
     * @const string
     */
    const PATH = __DIR__ . '/../data/address';

    /**
     * How many entries can are allowed in each INSERT INTO statement
     *
     * @const integer
     */
    const CHUNK_SIZE = 100;

    /**
     * Added in the .sql header
     *
     * @const string[]
     */
    const HEADER = [
        '-- Address',
        '--',
        '-- A database with every Country, State and County.',
        '--',
        '-- Help to include more countries and to keep this database updated',
        '--',
        '-- Remember to build the database before',
        '--',
        '-- @link https://www.github.com/aryelgois/Databases',
        '',
        'USE address;',
        '',
    ];

    /**
     * Contains all loaded data from countries
     *
     * @const array[]
     */
    protected $countries;

    /**
     * Creates a new Address object, loading countries data from YAML files
     *
     * @param string[] $countries List of countries to be included
     *
     * @throws \RuntimeException If a country YAML is not found
     */
    public function __construct(array $countries)
    {
        $data = [];
        foreach ($countries as $country_name) {
            $file = realpath(self::PATH . '/source_' . $country_name . '.yml');
            if (!file_exists($file)) {
                throw new \RuntimeException('File not found');
            }
            $data[$country_name] = Yaml::parse(file_get_contents($file));
        }
        $this->countries = $data;
    }

    /**
     * Generates SQL to populate the Address table
     *
     * @param integer $id_states   Last index inserted into table `states`
     * @param integer $id_counties Last index inserted into table `counties`
     *
     * @return string
     */
    public function output($id_states = 0, $id_counties = 0)
    {
        $sql = self::HEADER;
        foreach ($this->countries as $country_name => $country) {
            $states = [];
            $state_names = [];
            $counties = [];
            foreach ($country['states'] as $state) {
                $states[] = sprintf(
                    "(%s, %s, '%s', '%s')",
                    ++$id_states,
                    $country['country'],
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

            $count = count($country['states']);
            $sql = array_merge(
                $sql,
                [
                    '--',
                    '-- ' . $country_name . ' (' . $count . ' State'. ($count > 1 ? 's' : '') . ')',
                    '--',
                ],
                $states_sql,
                $counties_sql
            );
        }

        return implode("\n", $sql);
    }
}
