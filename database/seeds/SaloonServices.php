<?php

use App\Category;
use App\Product;
use Illuminate\Database\Seeder;

class SaloonServices extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::query()->delete();
        Category::query()->delete();
        $salonServices = array(
            array(
                'category' => 'تصفيف وقص الشعر',
                'services' => array(
                    'قص الشعر',
                    'تنعيم وتجعيد الشعر',
                    'صبغ وتلوين الشعر'
                )
            ),
            array(
                'category' => 'خدمات العناية بالبشرة',
                'services' => array(
                    'تنظيف البشرة',
                    'تقشير الوجه',
                    'ترطيب البشرة',
                    'علاج حب الشباب'
                )
            ),
            array(
                'category' => 'خدمات الأظافر',
                'services' => array(
                    'تقديم وتلميع الأظافر',
                    'تطبيق الجل البولندي (جل الأظافر)',
                    'تصميم الأظافر ورسمها (نايل آرت)'
                )
            ),
        );
        foreach ($salonServices as $category) {
            $cat = Category::query()->firstOrCreate(['name' => $category['category']], ['name' => $category['category'], 'type' => 1]);

            foreach ($category['services'] as $service) {
                Product::query()->firstOrCreate(
                    ['name' => $service],
                    ['name' => $service, 'main_category_id' => $cat->id, 'last_cost' => rand(10, 50), 'code' => rand(1000, 9000), 'is_service' => 1]
                );
            }
        }
    }
}
