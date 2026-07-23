<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Admin\RegistrationLeadController;
use Illuminate\Http\Request;

class TestError extends Command
{
    protected $signature = 'test:error';

    public function handle()
    {
        try {
            $controller = app(RegistrationLeadController::class);
            $request = Request::create('/admin/registration-leads', 'GET');
            $response = $controller->index($request);
            $response->render();
            $this->info("SUCCESS");
        } catch (\Throwable $e) {
            $this->error("ERROR: " . $e->getMessage());
            $this->error($e->getFile() . ':' . $e->getLine());
        }
    }
}
