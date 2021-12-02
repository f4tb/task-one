<?php

namespace App\Repository;

use App\Models\Contact;
use Carbon\Carbon;

class UserRepository
{
    public static function statisticsByDay($user = null)
    {
        $qb = Contact::query();
        if ($user){
            $qb->where('user_id', $user);
        }
        $from = Carbon::now()->subDay();
        $to = Carbon::now();
        $qb->whereBetween('created_at', [$from, $to]);
        return $qb->count();
    }

    public static function statisticsByWeek($user = null)
    {
        $qb = Contact::query();
        if ($user){
            $qb->where('user_id', $user);
        }
        $from = Carbon::now()->subWeek();
        $to = Carbon::now();
        $qb->whereBetween('created_at', [$from, $to]);
        return $qb->count();
    }

    public static function statisticsByMonth($user = null)
    {
        $qb = Contact::query();
        if ($user){
            $qb->where('user_id', $user);
        }
        $from = Carbon::now()->subMonth();
        $to = Carbon::now();
        $qb->whereBetween('created_at', [$from, $to]);
        return $qb->count();
    }
}
