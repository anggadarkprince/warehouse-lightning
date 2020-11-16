<?php

namespace App\Providers;

use App\Models\Booking;
use App\Models\BookingType;
use App\Models\Container;
use App\Models\Customer;
use App\Models\DeliveryOrder;
use App\Models\DocumentType;
use App\Models\Goods;
use App\Models\Report;
use App\Models\ReportStock;
use App\Models\ReportStockMovement;
use App\Models\Role;
use App\Models\Setting;
use App\Models\TakeStock;
use App\Models\Upload;
use App\Models\User;
use App\Models\WorkOrder;
use App\Policies\BookingPolicy;
use App\Policies\BookingTypePolicy;
use App\Policies\ContainerPolicy;
use App\Policies\CustomerPolicy;
use App\Policies\DeliveryOrderPolicy;
use App\Policies\DocumentTypePolicy;
use App\Policies\GoodsPolicy;
use App\Policies\ReportPolicy;
use App\Policies\RolePolicy;
use App\Policies\SettingPolicy;
use App\Policies\TakeStockPolicy;
use App\Policies\UploadPolicy;
use App\Policies\UserPolicy;
use App\Policies\WorkOrderPolicy;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Role::class => RolePolicy::class,
        User::class => UserPolicy::class,
        Setting::class => SettingPolicy::class,
        DocumentType::class => DocumentTypePolicy::class,
        BookingType::class => BookingTypePolicy::class,
        Customer::class => CustomerPolicy::class,
        Container::class => ContainerPolicy::class,
        Goods::class => GoodsPolicy::class,
        Upload::class => UploadPolicy::class,
        Booking::class => BookingPolicy::class,
        DeliveryOrder::class => DeliveryOrderPolicy::class,
        WorkOrder::class => WorkOrderPolicy::class,
        TakeStock::class => TakeStockPolicy::class,
        Report::class => ReportPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('super-admin', function ($user) {
            return $user->isAdministrator()
                ? Response::allow()
                : Response::deny('You must be a management member.');
        });
    }
}
