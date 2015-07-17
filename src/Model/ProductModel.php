<?php

namespace Pennyblossom\Client\Model;

class ProductModel
{
    private $code;

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }
}
