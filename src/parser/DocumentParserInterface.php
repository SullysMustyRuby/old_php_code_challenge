<?php

namespace Parser;

interface DocumentParserInterface
{
    public function validateFileType(string $file) : bool;
}
