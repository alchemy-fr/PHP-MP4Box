CHANGELOG
---------

* 0.2.2 (xx-xx-xxxx)

  * Split unit and functional tests

* 0.2.1 (04-24-2013)

  * Add support for timeout in ServiceProvider
  * Move tests in their own namespace

* 0.2.0 (04-24-2013)

  * Use alchemy/binary-driver as base driver
  * BC Break : `MP4Box::load()` is replaced by `MP4Box::create()`. `load` now
    allows a driver creation with a customized binary path.
  * BC Break : Invoking constructor is deprecated in favor of `load` and `create`
    methods.
  * BC Break : There are no more `open` and `close` methods. The `process` method
    now takes input and output files as argument.

* 0.1.1 (01-11-2012)

  * Adjust composer dependencies with the tilde operator, adjust to larger dependencies

* 0.1.0 (12-21-2012)

  * First stable version.
