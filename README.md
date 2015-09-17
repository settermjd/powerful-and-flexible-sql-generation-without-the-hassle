# About 

This project supports my talk: “**Powerful and Flexible SQL Generation without the Hassle**”. 

## Talk Abstract

PHP is almost synonymous with databases, and it has been since the early versions. Yet creating SQL queries can still be a challenging task. 

What’s the right tool to use? ORMs often feel like overkill, and creating queries by hand can be unmaintainable. In this session, I’ll show you how to use [the \Zend\Db library](http://framework.zend.com/manual/current/en/modules/zend.db.adapter.html) to generate SQL queries — from simple selects to more complex unions, filtered deletions, and updates. 

You’ll learn how to use the library to create *flexible*, *secure*, *maintainable*, and *reusable* queries quickly and efficiently, **saving you time and effort in the long term**.

## Repository Purpose

The purpose of the repository is two-fold. Firstly, it makes the examples as easy to create and execute as possible, so that the talk is focused, and to the point. Secondly, it makes the extracted resultsets and generated SQL queries as easy to read in the console as possible.

## What Does It Do?

It sets up a database connection to a SQLite database, and provides some helper functions, which make rendering the console output easier.

It makes use of the excellent [Symfony Console library](https://github.com/symfony/Console), which contains a [table helper](http://symfony.com/doc/current/components/console/helpers/tablehelper.html). These make the extracted resultsets easy to read. It also uses [jdorn/sql-formatter](https://github.com/jdorn/sql-formatter/) to format and render the generated SQL.

## Questions?

If you have any questions, just tweet me. I’m [@settermjd](https://twitter.com/@settermjd). 