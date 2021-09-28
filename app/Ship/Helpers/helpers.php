<?php

/*
|--------------------------------------------------------------------------
| Ship Helpers
|--------------------------------------------------------------------------
|
| Write only general helper functions here.
| Module specific helper functions should go into their own related Modules.
|
*/

if (!function_exists('count_on_page')) {
    /**
     * @param int $page
     * @param int $total
     * @param int|null $perPage
     *
     * @return int
     * @throws Exception
     */
    function count_on_page(int $page, int $total, ?int $perPage = null): int
    {
        $perPage = $perPage ?? (int) config('json-api-paginate.default_size', 0);

        if (!($perPage > 0)) {
            throw new \Exception("perPage argument not passed");
        }

        $lastPage = (int) ceil($total / $perPage);

        if ($page === $lastPage) {
            return $total - ($page - 1) * $perPage;
        }

        if ($page > $lastPage) {
            return 0;
        }

        return $perPage;
    }
}
