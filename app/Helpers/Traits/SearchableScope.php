<?php


namespace App\Helpers\Traits;


trait SearchableScope
{

    public function scopeSearchPagination($query, $search, $limit = 25, $visible = null)
    {
        /** @var Illuminate\Database\Query\Builder $query */
        $query = $query->search($search, null, true, true)->orderBy('created_at', 'DESC');
        $lengthAwarePaginator = $query->paginate($limit);
        if ($visible)
            $lengthAwarePaginator->setCollection($lengthAwarePaginator->getCollection()->makeVisible($visible));
        return $lengthAwarePaginator;
    }

}
