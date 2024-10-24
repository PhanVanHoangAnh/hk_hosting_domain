<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    /**
     * Exception alert
     *
     * @var string
     */
    protected $message = 'Lỗi xảy ra';

    /**
     * Custom error code
     *
     * @var int
     */
    protected $code = 500;

    /**
     * Bonus information about exception
     *
     * @var array
     */
    protected $additionalInfo;

    /**
     * Constructor
     *
     * @param string $message
     * @param int $code
     * @param array $additionalInfo
     * @param Exception|null $previous
     */
    public function __construct($message = null, $code = 0, $additionalInfo = [], Exception $previous = null)
    {
        if ($message !== null) {
            $this->message = $message;
        }

        if ($code !== 0) {
            $this->code = $code;
        }

        $this->additionalInfo = $additionalInfo;

        parent::__construct($this->message, $this->code, $previous);
    }

    /**
     * Get infor about exception
     *
     * @return array
     */
    public function getAdditionalInfo()
    {
        return $this->additionalInfo;
    }
}
