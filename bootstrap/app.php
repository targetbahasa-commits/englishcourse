<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(\App\Http\Middleware\RedirectApexToWww::class);
        $middleware->authenticateSessions();
        $middleware->redirectGuestsTo(function ($request) {
            if ($request->is('teacher') || $request->is('teacher/*')) {
                return secure_url('/teacher/login');
            }
            if ($request->is('student') || $request->is('student/*')) {
                return secure_url('/student/login');
            }

            return secure_url('/');
        });
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'check.assignment.program.access' => \App\Http\Middleware\CheckAssignmentProgramAccess::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

if (str_ends_with(base_path(), 'public_html')) {
    $app->usePublicPath(base_path());
}

return $app;
