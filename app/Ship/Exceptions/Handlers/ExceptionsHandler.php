<?php

namespace App\Ship\Exceptions\Handlers;

use Laraneat\Core\Abstracts\Exceptions\Handlers\ExceptionsHandler as CoreExceptionsHandler;
use App\Ship\Abstracts\Exceptions\Exception as ParentException;
use Throwable;

/**
 * Class ExceptionsHandler
 *
 * A.K.A (app/Exceptions/Handler.php)
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class ExceptionsHandler extends CoreExceptionsHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register(): void
    {
        $this->reportable(static function (Throwable $e) {
            //
        });

        $this->renderable(function (ParentException $e) {
            $response = env('APP_DEBUG') ? [
                'message' => $e->getMessage(),
                'errors' => $e->getErrors(),
                'exception' => static::class,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->gettrace()
            ] : [
                'message' => $e->getMessage(),
                'errors' => $e->getErrors()
            ];

            return response()->json($response, $e->getCode());
        });
    }
}
