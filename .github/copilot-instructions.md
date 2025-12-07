<!-- Copilot / AI agent instructions for contributors and bots -->
# Repository-specific guidance for AI coding agents

This project is a Laravel (PHP 8.2+) application using Inertia + React (TypeScript) with Vite for frontend builds and Laravel Fortify for auth. The goal of these instructions is to help AI coding agents be immediately productive and produce changes that match project conventions.

Key concepts
- **Backend:** Laravel app in `app/` with routes in `routes/*.php`. Authentication is handled by Laravel Fortify — see `app/Providers/FortifyServiceProvider.php` and `app/Actions/Fortify/` for action classes.
- **Frontend:** Inertia + React pages live under `resources/js/pages/*.tsx`. Entry: `resources/js/app.tsx`. Server-side rendering entry: `resources/js/ssr.tsx` (referenced from `vite.config.ts`).
- **Build tooling:** Vite + `laravel-vite-plugin` configured in `vite.config.ts`. Tailwind is used via `resources/css/app.css` and the `@tailwindcss/vite` plugin.
- **Tests:** PHPUnit configuration at `phpunit.xml` runs tests against an in-memory SQLite DB (`DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:`). Use `@php artisan test` or the composer script `composer run test`.

Common developer workflows (exact commands)
- Setup (fresh checkout):
  - `composer run setup` — composer script runs `composer install`, copies `.env`, generates app key, migrates, installs npm deps and builds assets. Run this in project root.
  - If you prefer step-by-step: `composer install; cp .env.example .env; php artisan key:generate; php artisan migrate --force; npm install; npm run build`
- Local development (full stack):
  - `composer run dev` — runs `php artisan serve`, queue listener, pail, and `npm run dev` together via `concurrently` (see `composer.json` scripts).
  - For SSR-enabled development: `composer run dev:ssr` (runs `npm run build:ssr` then starts server + `php artisan inertia:start-ssr`).
- Frontend-only:
  - `npm run dev` — starts Vite dev server
  - `npm run build` — production frontend build
  - `npm run build:ssr` — builds both client and SSR bundles
- Linting / formatting / types:
  - `npm run lint` — eslint autofix
  - `npm run format` — prettier formatting for `resources/`
  - `npm run types` — run TypeScript type check
- Tests:
  - `composer run test` or `php artisan test` (phpunit uses in-memory sqlite per `phpunit.xml`).

Important repository conventions and patterns
- Inertia Pages: pages are resolved via `resolvePageComponent('./pages/${name}.tsx', import.meta.glob('./pages/**/*.tsx'))` in `resources/js/app.tsx`. When you add a page, add `resources/js/pages/MyPage.tsx` and reference it via `Inertia::render('MyPage')` in Laravel routes.
- Fortify customization: authentication views are implemented as Inertia pages (see `FortifyServiceProvider::loginView` mapping to `auth/login`). Custom actions live in `app/Actions/Fortify/` and are bound in `app/Providers/FortifyServiceProvider.php`.
- Vite inputs: `vite.config.ts` lists `resources/css/app.css` and `resources/js/app.tsx` as inputs and registers SSR at `resources/js/ssr.tsx`. If modifying entry points, update `vite.config.ts`.
- Styling: Tailwind config and usage follows standard Tailwind; see `resources/css/app.css`.
- Tests run in isolation: `phpunit.xml` sets environment variables to avoid external services (queue sync, array cache, in-memory DB). When writing tests, assume no real DB or queue unless explicitly enabled in the test.

Integration points and external dependencies
- Laravel Fortify (`laravel/fortify`): auth flows and two-factor setup. Check `app/Actions/Fortify/*` and `app/Providers/FortifyServiceProvider.php` for hooks.
- Inertia + React (`@inertiajs/react`): server-client page sync. Pages under `resources/js/pages` are the primary UI surface.
- Vite + laravel-vite-plugin: asset pipeline. Use the existing `npm` scripts and `vite.config.ts` conventions.

How to make safe, useful changes
- Reference existing files when modifying behavior: prefer editing `app/Providers/*` and `app/Actions/*` for auth, `routes/*.php` for HTTP surface, and `resources/js/pages/*` for UI.
- When changing API/route contracts, update a matching Inertia page or controller and add/adjust tests under `tests/Feature` or `tests/Unit`.
- Keep TypeScript pages consistent with `resolvePageComponent` pattern; export the page as default from the file path matching the Inertia page name.

Examples (quick snippets)
- Add a route that renders an Inertia page:
  - `routes/web.php`:
    - `Route::get('reports', fn() => Inertia::render('reports/Index'))->name('reports.index');`
  - Create `resources/js/pages/reports/Index.tsx` and export default the component.

If something is unclear or you'd like more detail (e.g., examples for tests, SSR debugging steps, or common refactors), tell me which area to expand and I will iterate on this file.
