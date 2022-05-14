<?php

namespace App\Http\Controllers;

use Flugg\Responder\Responder;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @url https://github.com/flugg/laravel-responder#creating-transformers
     * @var Responder
     */
    protected Responder $responder;
    protected Dispatcher $dispatcher;
    protected ConnectionInterface $connection;

    public function __construct(
        ConnectionInterface $connection,
        Dispatcher $dispatcher,
        Responder $responder
    ) {
        $this->connection = $connection;
        $this->dispatcher = $dispatcher;
        $this->responder = $responder;
    }
}
