<?php

namespace Parser;

interface ParserInterface
{
    public function validateFileType(string $file) : bool;
    public function parse($file_stream, callable $formatter) : ?array;
}
