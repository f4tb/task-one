<?php

namespace App\Repository;

use App\Models\Contact;
use App\Service\ContactService;

class ContactRepository
{
    public static function bulkInsert(array $contacts, $user)
    {
        $contacts_insert = ContactService::generateBulkInsert($contacts, $user);
        Contact::insert($contacts_insert);
    }
}
