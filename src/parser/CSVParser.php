<?php

namespace Parser;

class CSVParser implements ParserInterface
{
    public string $file_type = 'csv';
    public $file_stream;

    public function validateFileType(string $file) : bool
    {
        $str_position_check = -1 * abs(strlen($this->file_type)) - 1;
        return substr($file, -4) === '.' . $this->file_type;
    }

    public function parse($file, callable $formatter) : ?array
    {
        $data        = [];
        $file_stream = fopen($file, "r");
        $iteration   = 0;
        
        while (($csvdata = fgetcsv($file_stream)) !== FALSE) {
            $data[] = call_user_func_array( $formatter, [$csvdata, $data, $iteration] );
            $iteration++;
        }

        fclose($file_stream);
        return array_filter($data);
    }
}
