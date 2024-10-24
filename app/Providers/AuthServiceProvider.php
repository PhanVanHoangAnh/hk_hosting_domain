<?php

namespace App\Providers;

use App\Models\AbroadApplication;
use App\Models\Order;
use App\Models\User;
use App\Library\Branch;
use App\Policies\UserPolicy;
use App\Policies\OrderPolicy;
use App\Policies\NoteLogPolicy;
use App\Policies\AbroadApplicationPolicy;
use App\Policies\BranchPolicy;
// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Order::class => OrderPolicy::class,
        Contact::class => ContactPolicy::class,
        NoteLog::class => NoteLogPolicy::class,
        AbroadApplication::class => AbroadApplicationPolicy::class,
        Branch::class => BranchPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
