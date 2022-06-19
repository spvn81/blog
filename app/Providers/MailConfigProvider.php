<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\emailConfiguration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class MailConfigProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {




if(Schema::hasTable('email_configurations')){
    $configuration = DB::table('email_configurations')->first();

                    $config = array(
                    'driver'     =>     $configuration->driver,
                    'host'       =>     $configuration->host,
                    'port'       =>     $configuration->port,
                    'username'   =>     $configuration->user_name,
                    'password'   =>     $configuration->password,
                    'encryption' =>     $configuration->encryption,
                    'from'       =>     array('address' => $configuration->sender_email, 'name' => $configuration->sender_name),

                );
                Config::set('mail', $config);

            }




    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {





    }
}
