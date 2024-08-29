<?php

namespace Dnonov\JsonParser\Providers;

use Illuminate\Support\ServiceProvider;

class JsonParserServiceProvider extends ServiceProvider {
    public function boot(): void { dd('v'); }
    public function register(): void {}
}
