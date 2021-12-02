<?php

namespace App\Service;

use Carbon\Carbon;

class ContactService
{
    public static function generateBulkInsert(array $contacts, $user)
    {
        $contacts_insert = array();
        foreach ($contacts as $contact){
            $contacts_insert[] = [
                'name' => $contact['name'],
                'phone_number' => $contact['phone_number'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_id' => $user->id,
            ];
        }
        return $contacts_insert;
    }
}
