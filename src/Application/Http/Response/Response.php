<?php

namespace Application\Http\Response;

class Response
{

    const OK_HTTP_RESPONSE_CODE = 200;
    const BAD_REQUEST_HTTP_RESPONSE_CODE = 400;
    const NOT_FOUND_RESPONSE_CODE = 404;
    const INTERNAL_ERROR_HTTP_RESPONSE_CODE = 500;

    /** @var string */
    private $message;
    /** @var int */
    private $code;

    public function __construct(string $message = '', int $code = self::OK_HTTP_RESPONSE_CODE)
    {
        $this->message = $message;
        $this->code = $code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCode(): int
    {
        return $this->code;
    }
}