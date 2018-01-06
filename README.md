# Intro

## (pt_BR)

Alguns bancos de dados úteis para seus projetos.

- Compile os esquemas dos bancos de dados com [YASQL-PHP]
- Use os bancos de dados em sua aplicação com modelos [Medools]


## (en_US)

Some useful databases for your projects.

- Build the database schemas with [YASQL-PHP]
- Use the databases in your application with [Medools] models


# Install

Run in your project:

`composer require aryelgois/databases`


# Setup

#### YASQL-PHP

You can add the following to your YASQL builder config file, to have all
databases available in this package.

```yaml
vendors:
  aryelgois/databases: ~
```


#### Medools

Create a Medools config file like in the [example][medools_example], or if you
already have one, add the database items you want.

Note that Medools has a single _charset_ configuration, so try to keep your
databases consistent.


# Databases

See detailed documentation for each database:

- [Address] _A database with every Country, State and County_


[medools_example]: config/medools_example.php
[Address]: doc/address.md

[YASQL-PHP]: https://github.com/aryelgois/yasql-php
[Medools]: https://github.com/aryelgois/Medools
