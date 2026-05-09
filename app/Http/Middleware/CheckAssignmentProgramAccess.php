<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\ProgramAccess;
use App\Models\Program;

class CheckAssignmentProgramAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'student') {
            return $next($request);
        }

        // Try to get program_id from route or request
        $programId = $request->route('program_id') ?? $request->input('program_id');
        if (!$programId) {
            // Try to infer from URL segments (for deeply nested assignment routes)
            $segments = $request->segments();
            $programSlug = $segments[1] ?? null;
            if ($programSlug) {
                $program = Program::where('slug', $programSlug)->first();
                if ($program) {
                    $programId = $program->id;
                }
            }
        }

        if ($programId) {
            $hasAccess = ProgramAccess::where('user_id', $user->id)
                ->where('program_id', $programId)
                ->exists();
                
            $hasEnrollment = \App\Models\Enrollment::where('user_id', $user->id)
                ->where('program_id', $programId)
                ->whereIn('status', ['active', 'completed'])
                ->exists();

            if (!$hasAccess && !$hasEnrollment) {
                return redirect()->route('assignments.index')->with('error', 'Akses ke program ini tidak diizinkan. Silakan tunggu konfirmasi admin.');
            }
        }

        return $next($request);
    }
}
