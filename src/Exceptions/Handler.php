<?php

namespace Kravinskiy\LaravelChassis\Exceptions;

use Kravinskiy\LaravelChassis\Exceptions\HttpResponse\ForbiddenException;
use Kravinskiy\LaravelChassis\Exceptions\HttpResponse\HttpException;
use Kravinskiy\LaravelChassis\Exceptions\HttpResponse\InternalErrorException;
use Kravinskiy\LaravelChassis\Exceptions\HttpResponse\MethodNotAllowedException;
use Kravinskiy\LaravelChassis\Exceptions\HttpResponse\NotFoundException;
use Kravinskiy\LaravelChassis\Exceptions\HttpResponse\UnauthorizedException;
use Kravinskiy\LaravelChassis\Http\Responses\BadResponse;
use Kravinskiy\LaravelChassis\Models\Reason\Reason;
use Kravinskiy\LaravelChassis\Models\StandardResponse\BadResponse\BadResponseError;
use Kravinskiy\LaravelChassis\Models\StandardResponse\Message\Message;
use Exception;
use Kravinskiy\LaravelChassis\Exceptions\Exception as StandardException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException as SymfonyHttpException;
use Kravinskiy\LaravelChassis\Exceptions\ValidationException as StandardValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * @param Exception $exception
     * @return mixed|void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * @param Request $request
     * @param Exception $exception
     * @return JsonResponse|Response
     * @throws Exception
     * @throws HttpException
     * @throws InternalErrorException
     * @throws MethodNotAllowedException
     * @throws StandardException
     * @throws StandardValidationException
     * @throws UnauthorizedException
     */
    public function render($request, Exception $exception)
    {
        if (method_exists($exception, 'render')) {
            $response = $exception->render($request);
            return Router::toResponse($request, $response);
        }

        if ($exception instanceof Responsable) {
            return $exception->toResponse($request);
        }

        /**
         * @var JsonResponse $standardResponse
         */
        $standardResponse = $this->handleExceptionWithStandardResponse($request, $exception);

        if (empty($standardResponse)) {
            return parent::render($request, $exception);
        }

        return $standardResponse;
    }

    /**
     * @param Request $request
     * @param Exception $exception
     * @return null|Response
     * @throws HttpException
     * @throws InternalErrorException
     * @throws MethodNotAllowedException
     * @throws StandardException
     * @throws StandardValidationException
     * @throws UnauthorizedException
     */
    private function handleExceptionWithStandardResponse(Request $request, Exception $exception): ?Response
    {
        // Only if not in debug mode
        if (config('app.debug') === true) {
            return null;
        }

        // We let the Domain and Reason objects decide on default values
        $domain = null;
        $reason = null;
        $errors = new Collection;

        $message = Message::fromString($exception->getMessage());

        if ($exception instanceof SymfonyHttpException) {
            $this->handleHttpException($exception, $message);
            return null;
        }

        if ($exception instanceof FatalErrorException) {
            $this->handleFatalException($exception, $message);
            return null;
        }

        if ($exception instanceof ValidationException) {
            $this->handleValidationException($exception);
            return null;
        }

        if ($exception instanceof Exception && !($exception instanceof StandardException)) {
            throw new StandardException($message, $exception->getCode());
        }

        if ($exception instanceof StandardException) {
            /** @var Reason $reason */
            $reason = $exception->getReason();
            $message = $exception->getCustomMessage();
            $errors = $exception->getErrors();
        }

        $statusCode = (int) $exception->getCode();

        // Since code never can be 0 or non-integer
        if ($statusCode === 0) {
            $statusCode = JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
        }

        return Router::toResponse(
            $request,
            BadResponse::create(
                $message,
                $statusCode,
                $reason,
                $errors
            )
        );
    }

    /**
     * @param SymfonyHttpException $exception
     * @param Message $message
     * @throws HttpException
     * @throws InternalErrorException
     * @throws MethodNotAllowedException
     * @throws StandardException
     * @throws UnauthorizedException
     */
    private function handleHttpException(SymfonyHttpException $exception, Message $message): void
    {
        switch ($exception->getStatusCode()) {
            case JsonResponse::HTTP_NOT_FOUND:
                throw new NotFoundException($message);
                break;
            case JsonResponse::HTTP_FORBIDDEN:
                throw new ForbiddenException($message);
                break;
            case JsonResponse::HTTP_METHOD_NOT_ALLOWED:
                throw new MethodNotAllowedException($message);
                break;
            case JsonResponse::HTTP_UNAUTHORIZED:
                throw new UnauthorizedException($message);
                break;
            case JsonResponse::HTTP_INTERNAL_SERVER_ERROR:
                throw new InternalErrorException($message);
                break;
            default:
                throw new HttpException($exception);
                break;
        }
    }

    /**
     * @param FatalErrorException $exception
     * @param Message $message
     * @throws InternalErrorException
     * @throws StandardException
     */
    private function handleFatalException(FatalErrorException $exception, Message $message): void
    {
        throw new InternalErrorException($message);
    }

    /**
     * @param ValidationException $validationException
     * @throws StandardException
     * @throws StandardValidationException
     */
    private function handleValidationException(ValidationException $validationException): void
    {
        $validationErrors = new Collection();

        foreach ($validationException->errors() as $key => $error) {
            if (empty($error[0])) {
                continue;
            }

            $validationError = new BadResponseError($key, Message::fromString($error[0]));
            $validationErrors->push($validationError);
        }

        throw new StandardValidationException($validationErrors);
    }
}