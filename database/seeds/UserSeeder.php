<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //DB::statement('SET FOREIGN_KEY_CHECKS=0');
        /*DB::table('user_stores')->truncate();
        DB::table('users')->truncate();
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('currencies')->truncate();
        DB::table('stores')->truncate();*/
        //DB::statement('SET FOREIGN_KEY_CHECKS=1');
        $admin = \App\User::firstOrCreate([ 'email'=>"أشرف"],[
            'name'           => "أشرف",
            'email'          => "أشرف",
            'password'       => bcrypt('Mai@1010'),
            'remember_token' => str_random(10)
        ]);
        $role = Role::firstOrCreate(['name'=> "admin"],['name'=> "admin",'display_name'=>'مسئول للنظام']);
        $admin->assignRole('admin');
        \App\Store::firstOrCreate(['name' => 'المنفذ الرئيسى'],['name' => 'المنفذ الرئيسى','mobile'=>'','note'=>'']);
        $admin->stores()->attach([1]);
        $role2 = Role::create(['name'=> "user",'display_name'=>'مستخدم']);
        $user = \App\User::create([
            'name'           => "demo",
            'email'          => "demo",
            'password'       => bcrypt(123456),
            'remember_token' => str_random(10)
        ]);

        $user->stores()->attach([1]);
        $user->assignRole('user');

        $disableController = [
            'LoginController',
            'RegisterController',
            'ForgotPasswordController',
            'ResetPasswordController',
        ];
        foreach (\Route::getRoutes() as $route)
        {
            $action = $route->getAction();

            if (array_key_exists('controller', $action))
            {
                $controllerAction = class_basename($action['controller']);
                list($controller, $method) = explode('@', $controllerAction);
                if(in_array($controller,$disableController))continue;
                $methods[$controller][] = $method;
            }
        }
        $allpermisions = [];
        foreach($methods as $cont=>$operations){
            foreach($operations as $v=>$op){
                $permissionName = $op.' '.$cont;
                $permission = Permission::firstOrCreate(['name' => $permissionName]);
                array_push($allpermisions,$permission);
            }
        }
        $role->syncPermissions($allpermisions);
        $role2->syncPermissions($allpermisions);

        //if(!currency()->hasCurrency('EGP')) {
            currency()->create([
                'name' => 'جنيه مصرى',
                'code' => config('currency.default'),
                'symbol' => 'ج.م',
                'format' => '1,0.00 ج.م',
                'exchange_rate' => 1,
                'active' => 1,
            ]);
        //}
        \App\Person::create(["name"=>"عميل كاش",'type'=>'client','priceType'=>'one']);
        \App\Person::create(["name"=>"مورد كاش",'type'=>'supplier','priceType'=>'one']);
       /* currency()->create([
            'name' => 'يورو',
            'code' => 'EUR',
            'symbol' => '€',
            'format' => '1,0.00 €',
            'exchange_rate' => 0.05,
            'active' => 1,
        ]);*/
       /* currency()->create([
            'name' => 'US Dollar',
            'code' => 'USD',
            'symbol' => '$',
            'format' => '1,0.00 $',
            'exchange_rate' => 0.058,
            'active' => 1,
        ]);*/
        //\Artisan::call('currency:manage add EGP,EUR,USD');
        //\Artisan::call('currency:update');

        DB::table('categories')->insert(
            array('name' => 'فئة 1','type'=>1)
        );
        DB::table('units')->insert(
            array('name' => 'قطعة')
        );

        //DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
