CHANGELOG
---------

* 0.2.0 (xx-xx-2013)

  * Use alchemy/binary-driver as base driver
  * BC Break : `MP4Box::load()` is replaced by `MP4Box::create()`. `load` now
    allows a driver creation with a customized binary path.
  * BC Break : Invoking constructor is deprecated in favor of `load` and `create`
    methods.

* 0.1.1 (01-11-2012)

  * Adjust composer dependencies with the tilde operator, adjust to larger dependencies

* 0.1.0 (12-21-2012)

  * First stable version.
