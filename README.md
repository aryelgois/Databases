# Intro

## (pt_BR)

Alguns bancos de dados úteis para seus projetos. Compile os esquemas dos bancos
de dados com [YASQL-PHP].


## (en_US)

Some useful databases for your projects. Build the database schemas with
[YASQL-PHP].


# Install

Run in your project:

`composer require aryelgois/databases`


# Setup

You can add the following to your builder config file, to have all databases
available in this package.

```yaml
vendors:
  aryelgois\databases: ~
```


# Databases

See detailed documentation for each database:

- [Address] _A database with every Country, State and County_


[Address]: doc/address.md
[YASQL-PHP]: https://github.com/aryelgois/yasql-php
