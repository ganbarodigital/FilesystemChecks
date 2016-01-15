# CHANGELOG

## develop branch

### New

* Added support for checking for / requiring an executable file
  * Added `GanbaroDigital\Filesystem\Checks\IsExecutableFile`
  * Added `GanbaroDigital\Filesystem\Exceptions\E4xx_FileIsNotExecutable`
  * Added `GanbaroDigital\Filesystem\Requirements\RequireExecutableFile`

## 0.3.0 - Fri Jan 15 2015

### New

* Added support for requiring a readable file
  * Added `GanbaroDigital\Filesystem\Requirements\RequireReadableFile`
  * Added `GanbaroDigital\Filesystem\Exceptions\E4xx_FileIsNotReadable`

## 0.2.1 - Tue Sep 22 2015

### New

* Exceptions\E4xx_NotAbsoluteFolder - added

### Fixes

* Requirements\RequireAbsoluteFolderOrNull - throws clearer exceptions
* Requirements\RequireAbsoluteFolderOrNull - handle fake /tmp et al on OSX

## 0.2.0 - Mon Sep 21 2015

### Fixes

* Checks - now all support the standard `::check()` method
* Checks - dropped the interface for now (needs rethinking)
* Checks - stricter type checking
* E4xx_UnsupportedType - typo in `use` statement

### Test Fixes

* Added `Exceptions\Exxx_FilesystemException`
* Added `Exceptions\E4xx_FilesystemException`
* Added `Exceptions\E4xx_UnsupportedType`

## 0.1.0 - Wed Sep 2 2015

Initial release.
