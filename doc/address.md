# Address

> A database with every Country, State and County.


# Intro

Build an address database with the countries you want.

I have simplified into country, state and county. I know.. it's not just that,
because there are countries which divide into different things.. but lets keep
it simple. _If someone knows more generic names, please [pull request]_


## Database in 2 steps

1. Build the database with `composer yasql-build`
2. Run the generated `build/address.sql` in your server

> It only applies if you clone this repository. For adding it in your own
> project, see below.


# Adding in my project

Require this package with Composer, create a config file for [YASQL-PHP] and add
the following, then build your databases.

```yaml
vendors:
  aryelgois/databases: ~
```


# How to use

Create a table in your database with a one-to-many relation to `counties.id`.
With this index, you can find the State and the Country.

In a registration form for your application, you can dynamically fill `<select>`
elements with Countries, States and counties.


## Medools Models

It is provided models for this database tables, under the namespace
`aryelgois\Databases\Models\Address`.

So, in your application, load the Medools config file, then create objects from
the classes in this namespace to use them.

They are `READ_ONLY` because this database is populated during build time, thus
you will focus in the `dump()` and `load()` methods:

- `dump()`: return an array of rows in the database (you can filter for example
  all counties of a specific State)
- `load()`: access the data in a specific row (foreigns included). When creating
  a new object with an argument, this method is called

> It is a good idea to use `getInstance()` instead of `load()`, to reuse models
> already loaded.

If you wish to insert rows into the database using these models, you will have
to extend them to change the `READ_ONLY` configuration to `false`, and also
update the `FOREIGN_KEYS` to your new classes.


# Structure

There are three tables, one related to the other, making a chain.


## countries

The column `id` is what you use to reference the country, as it must imutable in
your project. It could be a `tinyint`, but I choose `smallint` because it was
too close to the limit.

> If any country change their name someday, or their code is changed, you just
> need a patch to update your database. New builds would be already updated.

The columns `code_a2`, `code_a3` and `code_number` follows the [ISO_3166-1].

The column `name_local` is how you call the country, or how it is called in the
actual country. Depends on your implementation, thats why it is NULL. `name_en`
is a fallback and is already filled for you.

> This is the only table already provided as .sql because it is short and
> relatively easy to maintain. Maybe, the `name_local` will be filled in the
> future. Maybe it will also become a YAML.


## states

Here, `id` is an `int`, because there might be a lot of States in the world.

`country` references to the countries table (one-to-many).

`code` should follow [ISO_3166-2], but the subdivision name is simplified to
just "state". The column allows up to 3 characters.

`name` is the local name. *Should it be `name_en` and `name_local` as in
countries? If is that so, the counties should as well.. but.. just so much work*


## counties

`id` has the same idea as in states table.

`state` references to the states table, also one-to-many.

`name` is the local name.

Simple as that.

Knowing the county id, you can find the State and the Country.


# How it works?

There is already a database schema and the contents for countries table. But
for each country, it is required a YAML listing every state and country, so the
script can generate a populating sql.

This YAML contains the country `id` hardcoded (as it is in the
[populate_countries.sql]) and sequences of states and counties.

In the generated sql, the INSERT INTO statements are divided into chunks, each
with no more than 100 entries.


# How can I help?

Write a YAML file for the another country in [source] and include it in the
[config file]. Then build the database to see if it works, so you can
[pull request] and we can use more countries in our databases.

The following countries are ready for use:

update     | Alpha-2 | Country
----------:|:-------:|:-------
2017-09-02 | BR      | Brazil


# TODO

- [ ] Add more country sources
- [ ] (Maybe) Add more tables


[source]: ../data/address/source
[config file]: ../config/databases.yml
[populate_countries.sql]: ../data/address/populate_countries.sql

[pull request]: https://github.com/aryelgois/databases/pulls

[YASQL-PHP]: https://github.com/aryelgois/yasql-php

[ISO_3166-1]: https://en.wikipedia.org/wiki/ISO_3166-1
[ISO_3166-2]: https://en.wikipedia.org/wiki/ISO_3166-2
