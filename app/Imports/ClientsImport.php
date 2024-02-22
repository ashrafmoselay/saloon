<?php

namespace App\Imports;

use App\Person;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ClientsImport implements ToCollection,WithStartRow
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
                'type'=>'client',
                'mobile'=>'',
                'is_client_supplier'=>0,
                'priceType'=>'one'
            ]);
            if($row[7]){
                $person->transactions()
                    ->create([
                        'value'=>$row[7] ,
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
