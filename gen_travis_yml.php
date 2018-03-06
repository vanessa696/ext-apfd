#!/usr/bin/env php
# autogenerated file; do not edit
language: c
sudo: false
dist: trusty

addons:
 apt:
  packages:
   - php5-cli
   - php-pear
   - valgrind

compiler:
 - gcc
 - clang

env:
 matrix:
<?php

$cur = "7.2";
$gen = include "./travis/pecl/gen-matrix.php";
$env = $gen([
	"PHP" => ["5.6", "7.0", "7.1", "master"],
	"enable_debug" => "yes",
	"enable_maintainer_zts" => "yes",
], [
	"PHP" => $cur,
	"enable_debug",
	"enable_maintainer_zts"
], [
	"CFLAGS" => "'-O0 -g --coverage'",
	"CXXFLAGS" => "'-O0 -g --coverage'",
	"PHP" => $cur,
]);
foreach ($env as $grp) {
	foreach ($grp as $e) {
		printf("  - %s\n", $e);
	}
}

?>

cache:
 directories:
  - $HOME/cache

before_cache:
 - find $HOME/cache -name '*.gcda' -o -name '*.gcno' -delete

install:
 - make -f travis/pecl/Makefile php

script:
 - make -f travis/pecl/Makefile ext PECL=apfd
 - make -f travis/pecl/Makefile test

after_success:
 - test -n "$CFLAGS" && cd .libs && bash <(curl -s https://codecov.io/bash) -X xcode -X coveragepy

