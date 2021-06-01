<?php

namespace Parser;

class CSVDocumentParser implements DocumentParserInterface
{
    public $file_type = 'csv';

    public function validateFileType(string $file) : bool
    {
        $str_position_check = -1 * abs(strlen($this->file_type)) - 1;

        return substr($file, -4) === '.' . $this->file_type;
    }
}
