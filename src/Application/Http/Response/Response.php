<?php

namespace Application\Http\Response;

class Response
{
    const OK_HTTP_RESPONSE_CODE = 200;
    const BAD_REQUEST_HTTP_REQUEST_RESPONSE_CODE = 400;
    const NOT_FOUND_RESPONSE_CODE = 404;
    const FORBIDDEN_HTTP_RESPONSE_CODE = 403;
    const INTERNAL_HTTP_RESPONSE_CODE = 500;
    const TIMEOUT_REQUEST_RESPONSE_CODE = 504;

    /**
     * @var string
     */
    private $message;
    /**
     * @var int
     */
    private $code;

    public function __construct(string $message = '', int $code = self::OK_HTTP_RESPONSE_CODE)
    {
        $this->message = $message;
        $this->code = $code;
    }

    public function updateResponse(string $message, int $code)
    {
        $this->message = $message;
        $this->code = $code;
    }
}