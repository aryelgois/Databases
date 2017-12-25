<?php
/**
 * This Software is part of aryelgois\Databases and is provided "as is".
 *
 * @see LICENSE
 */

namespace aryelgois\Databases;

/**
 * Generates a .sql to populate Address database
 *
 * It uses a JSON as source
 *
 * @author Aryel Mota Góis
 * @license MIT
 * @link https://www.github.com/aryelgois/Databases
 */
class Address
{
    /**
     * Path to JSONs
     *
     * @const string
     */
    const PATH = __DIR__ . '/../data/Address';

    /**
     * How many entries can are allowed in each INSERT INTO statement
     *
     * @const integer
     */
    const CHUNK_SIZE = 100;

    /**
     * Added in the .sql header
     *
     * @const string
     */
    const HEADER = "-- Address\n"
                 . "--\n"
                 . "-- A database with every Country, State and County.\n"
                 . "-- Help to include more countries and to keep this database updated\n"
                 . "--\n"
                 . "-- Remember to run create.sql and populate_countries.sql before\n"
                 . "--\n"
                 . "-- @link https://www.github.com/aryelgois/Databases\n"
                 . "USE address;\n";

    /**
     * Contains all loaded data from countries
     *
     * @const array[]
     */
    protected $countries;

    /**
     * Creates a new Address object, loading countries data from JSONs
     *
     * @param string[] $countries List of countries to be included
     *
     * @throws RuntimeException If a country JSON is not found
     */
    public function __construct(array $countries)
    {
        $data = [];
        foreach ($countries as $country_name) {
            $file = realpath(self::PATH . '/source_' . $country_name . '.json');
            if (!file_exists($file)) {
                throw new \RuntimeException('File not found');
            }
            $data[$country_name] = json_decode(file_get_contents($file), true);
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
        $sql = '';
        foreach ($this->countries as $country_name => $country) {
            $chunk_states = [];
            $count_states = 0;
            $sql_states = $this->aboutCountry($country_name) . "\n";
            $sql_counties = '';

            foreach ($country['states'] as $state) {
                if ($count_states == 0) {
                    $sql_states .= "INSERT INTO `states` (`id`, `country`, `code`, `name`) VALUES\n";
                }
                $chunk_states[] = '(' . ++$id_states . ', ' . $country['country'] . ", '" . $state['code'] . "', '" . str_replace("'", "\\'", $state['name']) . "')";

                $chunk_counties = [];
                $count_counties = 0;
                $sql_counties .= '-- ' . $country_name . ' -> ' . $state['name'] . "\n\n";
                foreach ($state['counties'] as $county) {
                    if ($count_counties == 0) {
                        $sql_counties .= "INSERT INTO `counties` (`id`, `state`, `name`) VALUES\n";
                    }
                    $chunk_counties[] = '(' . ++$id_counties . ', ' . $id_states . ", '" . str_replace("'", "\\'", $county) . "')";
                    if (++$count_counties == self::CHUNK_SIZE) {
                        $sql_counties .= implode(",\n", $chunk_counties) . ";\n\n";
                        $chunk_counties = [];
                        $count_counties = 0;
                    }
                }
                if (!empty($chunk_counties)) {
                    $sql_counties .= implode(",\n", $chunk_counties) . ";\n\n";
                }


                if (++$count_states == self::CHUNK_SIZE) {
                    $sql_states .= implode(",\n", $chunk_states) . ";\n";
                    $chunk_states = [];
                    $count_states = 0;
                }
            }
            if (!empty($chunk_states)) {
                $sql_states .= implode(",\n", $chunk_states) . ";\n";
            }

            $sql .= $sql_states . "\n"
                  . $sql_counties . "\n";
        }

        $result = self::HEADER . "\n\n"
                . $this->listCountries() . "\n\n"
                . $sql
                . "-- END";

        return $result;
    }

    /**
     * Generates SQL comment listing countries
     *
     * @return string
     */
    protected function listCountries()
    {
        $count = count($this->countries);
        $result = '-- Populating ' . $count . ' Countr' . ($count > 1 ? 'ies' : 'y') . "\n"
                . "--\n"
                . "-- update     |  id | name\n"
                . "-- ---------- | --- | ----\n";
        foreach ($this->countries as $country_name => $country) {
            $result .= '-- ' . $country['update'] . ' | ' . str_pad($country['country'], 3, ' ', STR_PAD_LEFT) . ' | ' . $country_name . "\n";
        }
        return $result;
    }

    /**
     * Generates SQL comment about a country
     *
     * @param string $country_name The country which info will be generated
     *
     * @return string
     */
    protected function aboutCountry($country_name)
    {
        $country = $this->countries[$country_name];
        $result = '-- ' . $country_name . "\n"
                . "--\n"
                . '-- ' . count($country['states']) . " States \n";
        if (array_key_exists('notes', $country)) {
            $result .= "--\n-- " . str_replace("\n", "\n-- ", $country['notes']) . "\n";
        }
        return $result;
    }
}
