<?php

namespace App\Http\Middleware;

use App\Models\Maintenance;
use Closure;
use Illuminate\Http\Request;

class CheckMaintenanceMode
{
    /**
     * メンテナンスモード確認
     *
     * @param Request $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $maintenance_record = Maintenance::where('maintenance_mode', true)->latest()->first();

        if ($maintenance_record) {
            return response(
                [
                    'status' => 'maintenance',
                    'description' => $maintenance_record->description
                ],
                503
            );
        }

        return $next($request);
    }
}
