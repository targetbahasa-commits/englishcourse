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
        // Appended to the 'web' group (not the global stack above) since it
        // needs the session to already be started for auth() to resolve.
        $middleware->web(append: [\App\Http\Middleware\UpdateLastSeen::class]);
        $middleware->redirectGuestsTo(function ($request) {
            if ($request->is('online-test') || $request->is('online-test/*')) {
                return secure_url('/test-taker/register');
            }
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
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, \Illuminate\Http\Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'CSRF token mismatch. Please refresh.',
                    'token' => csrf_token(),
                ], 419);
            }

            return redirect()->back()
                ->withInput($request->except(['password', 'password_confirmation', '_token']))
                ->with('error', 'Sesi Anda telah diperbarui secara otomatis demi keamanan. Silakan klik tombol Masuk kembali.');
        });

        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, \Illuminate\Http\Request $request) {
            if ($e->getStatusCode() === 419) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'CSRF token mismatch. Please refresh.',
                        'token' => csrf_token(),
                    ], 419);
                }

                return redirect()->back()
                    ->withInput($request->except(['password', 'password_confirmation', '_token']))
                    ->with('error', 'Sesi Anda telah diperbarui secara otomatis demi keamanan. Silakan klik tombol Masuk kembali.');
            }
        });
    })->create();

if (str_ends_with(base_path(), 'public_html')) {
    $app->usePublicPath(base_path());
}

return $app;
