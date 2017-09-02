# Address

A database with every Country, State and County.


## Intro

Build an address database with the countries you want. The index is
automatically generated for you, and if wou want to add more countries later,
you just need to give the last indexes and it will continue.

I have simplified into country, state and county. I know.. it's not that simple,
because there are countries which divide into different things.. but lets keep
it simple, shall we? _If someone knows more generic names, please push request_

The indexes are hardcoded to keep them imutable in your generated .sql and in
your project. So, it's recomended to save a copy just in case.


## Database in 3 steps

1. Run [create.sql][create] and [populate_countries.sql][countries] inside your
   database server
2. Generate a .sql populating the countries of your interest, as in the [example][example]
3. Run the generated .sql in your server


## How to use

Create a relational table in your project which links to counties table. With
this information, you can find the state and the country.

In your form, you can dynamically add `<select>`s for countries, states and
counties.


## Adding more countries

Create a new Address object with the desired countries and pass the last indexes
in your database to the `output()` method.


## Structure

There are thre tables, one related to the other, making a chain.


### Table countries

The column `id` is what you use to reference the country, as it should imutable
in your database. It could be a tinyint, but I prefered to keep smallint because
it was too close to the limit.

The columns `code_a2`, `code_a3` and `code_number` follows the [ISO_3166-1][ISO_3166-1].

The column `name_local` is how you call the country, or how it is called in the
actual country. Depends on your implementation, thats why it is NULL. `name_en`
is a fallback and is already filled for you.

> This is the only table already provided as .sql because it is short and easy
> to maintain. Maybe, the `name_local` will be filled in the future.


### Table states

Here, `id` is an int, because there might be a lot of states in the world.

`country` references to the countries table.

`code` should follow [ISO_3166-2][ISO_3166-2], but the subdivision name is
simplified to just "state". The column allows up to 3 characters.

`name` is the local name. _Should it be `name_en` and `name_local` as in
countries? If is that so, the counties should as well.. but.. just so much work_


### Table counties

`id` has the same idea as in states table.

`state` references to the states table.

`name` is the local name.

Simple as that.


## How it works

There is already a database structure and the contents for countries table. But
for each country, it is required a JSON listing every state and country, so the
script can generate the .sql.

This JSON contains the country `id` hardcoded (as it is in the [populating .sql][countries]),
a update timestamp of when it was last modified, optional notes and the list of
states and counties.

In the generated .sql, the INSERT statements are divided into chunks, each with
no more than 100 entries.


## How you can help

Producing JSON files with all states and counties of different countries, so we
can use more countries in the database.

The following countries are ready for use:

update     | Alpha-2 | Country
----------:|:-------:|:-------
2017-09-02 | BR      | Brazil

## TODO

- [ ] Clean up `output()`
- [ ] Add more country sources
- [ ] (Maybe) Add more tables


[create]: ../data/Address/create.sql
[countries]: ../data/Address/populate_countries.sql
[example]: ../examples/address.php
[ISO_3166-1]: https://en.wikipedia.org/wiki/ISO_3166-1
[ISO_3166-2]: https://en.wikipedia.org/wiki/ISO_3166-2
