<?php

namespace App\Providers;

use App\Repositories\Admin\Home\HomeInterface;
use App\Repositories\Admin\Home\HomeRepository;
use App\Repositories\Admin\Notification\NotificationInterface;
use App\Repositories\Admin\Notification\NotificationRepository;
use App\Repositories\Admin\Profile\ProfileInterface;
use App\Repositories\Admin\Profile\ProfileRepository;
use App\Repositories\Admin\User\UserInterface;
use App\Repositories\Admin\User\UserRepositories;
use App\Repositories\Client\Category\CategoryInterface;
use App\Repositories\Client\Category\CategoryRepository;
use App\Repositories\Client\Product\ProductInterface;
use App\Repositories\Client\Product\ProductRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CategoryInterface::class,CategoryRepository::class);
        $this->app->bind(ProductInterface::class,ProductRepository::class);
        $this->app->bind(ProfileInterface::class,ProfileRepository::class);
        $this->app->bind(\App\Repositories\Admin\Product\ProductInterface::class,\App\Repositories\Admin\Product\ProductRepository::class);
        $this->app->bind(NotificationInterface::class,NotificationRepository::class);
        $this->app->bind(\App\Repositories\Admin\Category\CategoryInterface::class,\App\Repositories\Admin\Category\CategoryRepository::class);
        $this->app->bind(HomeInterface::class,HomeRepository::class);
        $this->app->bind(UserInterface::class,UserRepositories::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
