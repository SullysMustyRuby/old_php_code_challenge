# Simple code challenge #

This code is an example from a real world scenario that has been modified to protect the source. The code is one file from a large PHP application.

The context of the file is a parser of a result file from a specific Singapore bank regarding bank transfers. There were multiple banks from multiple countries involved in this application.

To install the dependencies run `composer install` (this assumes you have composer installed in your environment)

The code works and outputs what it required. Included is one test file with one test. This can be run and should pass with `./vendor/bin/phpunit tests`

Read through the `src/FinalResult.php` as well as the test file `tests/FinalResultTest.php` and see what improvements can be made (if any). Please be prepared to explain any modifications that have been made (or not) and why. The only rule is to not change the current end result or output.

Keep in mind this is from a larger application that handles multiple files, multiple banks, mutiple countries, and multiple currencies.

Do the best you can to demonstrate your skillset.