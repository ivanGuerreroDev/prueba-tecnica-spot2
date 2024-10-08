<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
class HandleCors
{
    protected $allowedOrigins = ['http://localhost:3000'];

    public function handle(Request $request, Closure $next)
    {
        $origin = $request->header('Origin');
        if (in_array($origin, $this->allowedOrigins)) {
            return $next($request)
                ->header('Access-Control-Allow-Origin', $origin)
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type');
        }
        return $next($request);
    }
}
