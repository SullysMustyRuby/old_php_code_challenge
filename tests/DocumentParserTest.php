<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Parser\CSVParser;
use Parser\ExcelParser;
use Data\SingaporeBankData;

final class DocumentParserTest extends TestCase
{
    public function testTerminatesTheProcessIfCannotLocateFile(): void
    {
        $expected_return = [
            'status'  => 'parser_invalid',
            'code'    => 'file_not_exist',
            'message' => 'A file "/var/www/html/tests/support/file_is_not_here.csv" does not exist.',
        ];

        $file   = __DIR__ . '/support/file_is_not_here.csv';
        $parser = new DocumentParser(new SingaporeBankData($file), new CSVParser());
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

        $file   = __DIR__ . '/support/data_sample.csv';
        $parser = new DocumentParser(new SingaporeBankData($file), new ExcelParser());
        $parser->validate();

        $result = $parser->report();

        $this->assertEquals($expected_return, $result);
    }

    public function testTerminatesTheProcessIfFileHeaderFormatIsWrong(): void
    {
        $expected_return = [
            'status'  => 'parser_invalid',
            'code'    => 'file_wrong_format',
            'message' => 'Header format is wrong.'
        ];

        $file   = __DIR__ . '/support/data_sample_broken_header.csv';
        $parser = new DocumentParser(new SingaporeBankData($file), new CSVParser());
        $parser->validate();
        $parser->read();

        $result = $parser->report();

        $this->assertEquals($expected_return, $result);
    }

    public function testTerminatesTheProcessIfFileBodyFormatIsWrong(): void
    {
        $expected_return = [
            'status'  => 'parser_invalid',
            'code'    => 'file_wrong_format',
            'message' => 'Content format is wrong at line 9.'
        ];

        $file   = __DIR__ . '/support/data_sample_broken_body.csv';
        $parser = new DocumentParser(new SingaporeBankData($file), new CSVParser());
        $parser->validate();
        $parser->read();

        $result = $parser->report();

        $this->assertEquals($expected_return, $result);
    }
}
