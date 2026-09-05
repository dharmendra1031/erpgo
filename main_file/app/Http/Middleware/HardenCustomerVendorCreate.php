<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class HardenCustomerVendorCreate
{
    public function handle($request, Closure $next)
    {
        if ($request->isMethod('post') && in_array(trim($request->path(), '/'), ['customer', 'vender'], true)) {
            $request->validate([
                'password' => 'nullable|string|min:8',
            ]);

            if (!$request->filled('password')) {
                $request->merge(['password' => Str::random(16)]);
            }

            $addressFields = [
                'billing_name',
                'billing_country',
                'billing_state',
                'billing_city',
                'billing_phone',
                'billing_zip',
                'billing_address',
                'shipping_name',
                'shipping_country',
                'shipping_state',
                'shipping_city',
                'shipping_phone',
                'shipping_zip',
                'shipping_address',
            ];

            $normalized = [];
            foreach ($addressFields as $field) {
                $normalized[$field] = $request->input($field) ?: '';
            }

            $request->merge($normalized);
        }

        return $next($request);
    }
}
