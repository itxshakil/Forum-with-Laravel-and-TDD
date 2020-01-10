<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
    protected $request;
    protected $query;
    protected $filters = [];

    /**
     * Construct
     *
     * @param  mixed $request
     *
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * apply Filter
     *
     * @param  mixed $query
     *
     * @return mixed
     */
    public function apply($query)
    {
        $this->query = $query;

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->query;
    }

    public function getFilters()
    {
        return $this->request->only($this->filters);
    }
}
