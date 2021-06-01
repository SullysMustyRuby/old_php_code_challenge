<?php
/**
 * Dump class
 *
 * Note; 
 * In real-world application, some of methods inside this class 
 * could be refactored into its parent class to remove the redundant code.
 * However, as for code-challenge purpose, I think it is better to leave it 
 * as it is for now to demonstrate of the usefulness of "ParserInterface" interface.
 */

namespace Parser;

class ExcelParser implements ParserInterface
{
    public $file_type = 'excel';

    public function validateFileType(string $file) : bool
    {
        $str_position_check = -1 * abs(strlen($this->file_type)) - 1;
        return substr($file, -4) === '.' . $this->file_type;
    }

    public function parse($file_stream, callable $formatter) : ?array
    {
        // Dump method.
    }
}
