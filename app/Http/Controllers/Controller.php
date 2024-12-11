<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Mantax559\LaravelHelpers\Exceptions\UserFriendlyException;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    protected function resolveExceptionMessage($exception): string
    {
        if ($exception instanceof UserFriendlyException) {
            return $exception->getMessage();
        }

        if ($exception instanceof QueryException) {
            return $this->getQueryExceptionMessage($exception);
        }

        return $this->logErrorAndGetGenericMessage($exception);
    }

    private function getQueryExceptionMessage(QueryException $exception): string
    {
        return match ($exception->errorInfo[1]) {
            1062 => __('This record already exists in the system. Please review and ensure uniqueness before proceeding.'),
            1451 => __('This entry has related dependencies and cannot be deleted. Please review and address the related entries before attempting to remove this entry again.'),
            default => $this->logErrorAndGetGenericMessage($exception),
        };
    }

    private function logErrorAndGetGenericMessage($exception): string
    {
        $errorCode = Log::error($exception->getMessage());

        return __('An error has occurred, apologies for the inconvenience. If you encounter an error, please inform the administrator and provide the error code: :error_code', ['error_code' => $errorCode]);
    }
}
