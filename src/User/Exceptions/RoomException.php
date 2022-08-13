<?php

namespace User\Exceptions;

use Exception;

class RoomException extends Exception
{
    public function render()
    {
        return response()->json(['error' => $this->getMessage(), 'trace' => $this->getTrace()], $this->getCode());
    }
}
