<?php

namespace App\Filters;

use App\User;

class ThreadFilters extends Filters
{
    protected $filters = ['by', 'popular'];

    /**
     * Filter by User's name
     *
     * @param  mixed $username
     *
     * @return mixed
     */
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Return Threads by popularity
     *
     * @param  mixed $username
     *
     * @return mixed
     */
    protected function popular()
    {
        $this->builder->getQuery()->orders = [];

        return $this->builder->orderBy('replies_count', 'desc');
    }
}
