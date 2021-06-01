<?php

use Data\DataInterface;
use Parser\ParserInterface;

class DocumentParser
{
    protected DataInterface $data;
    protected ParserInterface $parser;
    private array $report = [];
    
    public function __construct(DataInterface $data, ParserInterface $parser)
    {
        $this->data = $data;
        $this->parser = $parser;
    }

    public function validate() : bool
    {
        if (!file_exists($this->data->file)) {
            $this->setReportFileNotExist();
            return false;
        }

        if (!$this->parser->validateFileType($this->data->file)) {
            $this->setReportWrongFileType();
            return false;
        }

        // Note; 
        // In real-world application, as this is an application related to bank, number, and money.
        // There might be some more that need to validate to make absolutely sure that the application
        // will not crash in the middle during the file reading.
        //
        // i.e. in a large scale of transactions, maybe we need to as well limit the file size to make sure
        // that the application can read through from the first to the last line without timeout, run out of memory, etc.
        // Or checking if the application has a permission to read the file.
        //
        // However, as for the code-challenge purpose, I would like to leave it as it is for now
        // until the requirement become more clear on what is the spec of each files from each banks.
        $this->setReportValid();
        return true;
    }

    public function read()
    {
        try {
            $this->parser->parse($this->data->file, [$this->data, 'format']);
        } catch (\Exception $e) {
            $this->setReportWrongFileFormat($e->getMessage());
            return false;
        }
    }

    public function data()
    {
        return $this->data;
    }

    public function report() : array
    {
        return $this->report;
    }

    private function setReportFileNotExist() : void
    {
        $this->report = [
            'status'  => 'parser_invalid',
            'code'    => 'file_not_exist',
            'message' => 'A file "tests/support/data_sample.csv" does not exist.',
        ];
    }

    private function setReportWrongFileType() : void
    {
        $this->report = [
            'status'  => 'parser_invalid',
            'code'    => 'file_wrong_type',
            'message' => 'A file type must be ' . ucfirst($this->parser->file_type) . ' file.'
        ];
    }

    private function setReportWrongFileFormat($message) : void
    {
        $this->report = [
            'status'  => 'parser_invalid',
            'code'    => 'file_wrong_format',
            'message' => $message
        ];
    }

    private function setReportValid() : void
    {
        $this->report = [
            'status'  => 'parser_valid',
            'code'    => 'parser_validated',
            'message' => '',
        ];
    }
}
