<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

/**
 * Centralized tenant resolver. Keeps logic in one place for tests and app code.
 *
 * Resolution order (first non-null wins):
 * - explicitly bound organization id via `app()->instance('current_organization_id', $id)`
 * - authenticated user's `organization_id` (if present)
 * - `X-Organization-Id` request header (useful for API calls)
 * - subdomain parsing (not implemented automatically here — add in resolver if you use subdomains)
 */
class TenantManager
{
    public static function getOrganizationId(): ?int
    {
        // allow tests or console to bind an explicit org id
        if (app()->bound('current_organization_id')) {
            return (int) app('current_organization_id');
        }

        // from authenticated user
        try {
            $user = Auth::user();
        } catch (\Throwable $e) {
            $user = null;
        }

        if ($user && isset($user->organization_id) && $user->organization_id) {
            return (int) $user->organization_id;
        }

        // from request header
        try {
            $header = Request::header('X-Organization-Id');
            if ($header) {
                return (int) $header;
            }
        } catch (\Throwable $e) {
            // ignore in non-http contexts
        }

        return null;
    }

    public static function setOrganizationId(?int $id): void
    {
        app()->instance('current_organization_id', $id);
    }
}
