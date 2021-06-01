<?php

namespace Data;

use Exception;
use Parser\ParserInterface;

class SingaporeBankData implements DataInterface
{
    public string $file;

    protected array $header = [];
    protected array $body   = [];

    public function __construct(string $file)
    {
        $this->file   = $file;
    }
    
    public function format($csvdata, $data, $iteration) : ?array
    {
        if ($iteration === 0) {
            $this->formatHeader($csvdata, $data, $iteration);
            return null;
        }

        if(count($csvdata) != 16) {
            throw new Exception('Content format is wrong at line '. $iteration + 1 .'.');
        }

        $amt = !$csvdata[8] || $csvdata[8] == "0" ? 0 : (float) $csvdata[8];
        $ban = !$csvdata[6] ? "Bank account number missing" : (int) $csvdata[6];
        $bac = !$csvdata[2] ? "Bank branch code missing" : $csvdata[2];
        $e2e = !$csvdata[10] && !$csvdata[11] ? "End to end id missing" : $csvdata[10] . $csvdata[11];
        $rcd = [
            "amount" => [
                "currency" => $this->header[0],
                "subunits" => (int) ($amt * 100)
            ],
            "bank_account_name" => str_replace(" ", "_", strtolower($csvdata[7])),
            "bank_account_number" => $ban,
            "bank_branch_code" => $bac,
            "bank_code" => $csvdata[0],
            "end_to_end_id" => $e2e,
        ];

        return $this->body[] = $rcd;
    }

    public function formatHeader($csvdata, $data, $iteration) : array
    {
        if (count($csvdata) !== 3) {
            throw new Exception('Header format is wrong.');
        }
        
        return $this->header = $csvdata;
    }

    public function output() : array
    {
        return [
            'filename'        => basename($this->file),
            'failure_code'    => $this->header[1],
            'failure_message' => $this->header[2],
            'records'         => $this->body
        ];
    }
}
