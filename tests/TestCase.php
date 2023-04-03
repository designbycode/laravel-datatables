<?php

namespace Designbycode\Datatables\Tests;

use Designbycode\Datatables\DatatablesServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Designbycode\\Datatables\\Tests\\Stubs\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('posts');
        parent::tearDown();
    }

    protected function getPackageProviders($app): array
    {
        return [
            DatatablesServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
//        $migration = include __DIR__.'/../database/migrations/create_datatables_table.php.stub';
//        $migration->up();

        Route::resource('posts', \Designbycode\Datatables\Tests\Stubs\PostController::class);

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content')->nullable();
            $table->timestamps();
        });
    }
}
