<?php

namespace App\Imports;

use App\Person;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SuppliersImport implements ToCollection,WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $person = Person::create([
                'name'=>$row[1],
                'type'=>'supplier',
                'mobile'=>$row[2],
                'is_client_supplier'=>0,
                'priceType'=>'one'
            ]);
            if($row[5]){
                $person->transactions()
                    ->create([
                        'value'=>$row[5] ,
                        'note'=>'رصيد أول المدة'
                    ]);
            }
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}
