<?php

declare(strict_types=1);

include_once 'src/DocumentParser.php';
include_once 'src/parser/DocumentParserInterface.php';
include_once 'src/parser/CSVDocumentParser.php';
include_once 'src/parser/ExcelDocumentParser.php';
include_once 'src/parser/format/SingaporeBankFormat.php';

use PHPUnit\Framework\TestCase;
use Parser\CSVDocumentParser;
use Parser\ExcelDocumentParser;
use Parser\Format\SingaporeBankFormat;

final class DocumentParserTest extends TestCase
{
    public function testTerminatesTheProcessIfCannotLocateFile(): void
    {
        $expected_return = [
            'status'  => 'parser_invalid',
            'code'    => 'file_not_exist',
            'message' => 'A file "tests/support/data_sample.csv" does not exist.',
        ];

        $parser = new DocumentParser(new CSVDocumentParser, new SingaporeBankFormat, 'tests/support/file_is_not_here.csv');
        $parser->validate();

        $result = $parser->report();

        $this->assertEquals($expected_return, $result);
    }

    public function testTerminatesTheProcessIfFileTypeIsWrong(): void
    {
        $expected_return = [
            'status'  => 'parser_invalid',
            'code'    => 'file_wrong_type',
            'message' => 'A file type must be Excel file.'
        ];

        $parser = new DocumentParser(new ExcelDocumentParser, new SingaporeBankFormat, 'tests/support/data_sample.csv');
        $parser->validate();

        $result = $parser->report();

        $this->assertEquals($expected_return, $result);
    }

    public function testTerminatesTheProcessIfFileFormatIsWrong(): void
    {
        $expected_return = [
            'status'  => 'parser_invalid',
            'code'    => 'file_wrong_format',
            'message' => 'A file format is wrong. The used format is "SingaporeBank".'
        ];

        $parser = new DocumentParser(new CSVDocumentParser, new SingaporeBankFormat, 'tests/support/data_wrong_sample.csv');
        $parser->validate();
        $parser->validateFormat();

        $result = $parser->report();

        $this->assertEquals($expected_return, $result);
    }
}