<?php

namespace Data;

interface DataInterface
{
    public function format($csvdata, $data, $iteration) : ?array;
    public function output() : array;
}
