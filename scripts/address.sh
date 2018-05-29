#!/usr/bin/env bash

set -e

CACHE_DIR=${CACHE_DIR:-.}

VERSION=0.1.0

REPO_VERSION=0.6.0

help () {
    PROGRAM="$(basename "$0")"
    cat <<EOF
Address_sourcer

Fetches addresses to prepare the YAML source for AddressPopulator

NOTE: sort(1) does not work properly. You need to resort the cached files.

Usage: $PROGRAM fetch COUNTRY_ID
  or:  $PROGRAM build COUNTRY_ID
  or:  $PROGRAM -h|--help
  or:  $PROGRAM -v|--version

Options:
  -h, --help      Output this message and exit
  -v, --version   Output the version, copyright and license, then exit

  fetch           Fetches files, applies regex and stores it in cache
  build           Builds the YAML file from cached files

  COUNTRY_ID      Id from populate_countries.sql

Environment:
  CACHE_DIR  Path to directory with caches. Inside of it, one directory for each
             COUNTRY_ID is created

Report bugs at <https://github.com/aryelgois/databases/issues>
Home page: <https://github.com/aryelgois/databases>
EOF
}

version () {
    PROGRAM="$(basename "$0")"
    cat <<EOF
Address_sourcer $VERSION

Copyright (C) 2018 Aryel Mota Góis.

License MIT: MIT License <https://github.com/aryelgois/databases/blob/v$REPO_VERSION/LICENSE>
This is free software: you are free to change and redistribute it.
There is NO WARRANTY, to the extent permitted by law.
EOF
}



build_source () {
    STATES="$(cat "$CACHE_DIR/$1/states")"
    COUNTIES="$(cat "$CACHE_DIR/$1/counties")"

    echo "country: $1"
    echo 'states:'

    while read -r STATE; do
        STATE_CODE="${STATE%% *}"
        STATE_NAME="${STATE#* }"

        echo "  - code: $STATE_CODE"
        echo "    name: $STATE_NAME"
        echo '    counties:'
        grep "^$STATE_CODE " <<< "$COUNTIES" | sed "s/^$STATE_CODE /      - /g"
    done <<< "$STATES"
}

fetch_source () {
    fetch_${1}_states | sort > "$CACHE_DIR/$1/states"
    fetch_${1}_counties | sort > "$CACHE_DIR/$1/counties"
}



fetch_32_states () {
    URL='https://pt.wikipedia.org/wiki/Unidades_federativas_do_Brasil'

    wget -O - "$URL" |
        grep '^<td>' | sed -rz 's/<td><a[^>]*title="[^"]*">([^<]+)<\/a><\/td>\n<td>(\w+)<\/td>/\2 \1/g' | grep '^<td>' -v
}

fetch_32_counties () {
    URL='https://pt.wikipedia.org/wiki/Lista_de_munic%C3%ADpios_do_Brasil'

    wget -O - "$URL" |
        grep '^<li>' | sed -r 's/^<li><a.*>(.+)<\/a> \((\w+)\)<\/li>/\2 \1/g' | grep '^<li>' -v

    fetch_32_counties_DF
}

fetch_32_counties_DF () {
    URL='https://pt.wikipedia.org/wiki/Regi%C3%B5es_administrativas_do_Distrito_Federal_(Brasil)'

    wget -O - "$URL" |
        grep '^<td>' | sed -r 's/<a.*title="[^"]*">(.+)<\/a><\/td>/\nDF \1/g' | grep '^<td>' -v
}



case $1 in
-h|--help)
    help
    exit
    ;;
-v|--version)
    version
    exit
    ;;

build)
    build_source "$2"
    ;;
fetch)
    fetch_source "$2"
    ;;

*)
    >&2 help
    exit 1
    ;;
esac
