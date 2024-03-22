<?php

namespace App\Actions\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class OrderBy
{
    /**
     * Order by the given column.
     */
    public function handle(Request $request, $modelClass): Builder
    {
        //Ordering
        $order_by_field = $request->has('order_by') ? $request->order_by : 'id';
        $order_by_direction = $request->has('direction') ? $request->direction : 'asc';

        // Ensure the order is safe and matches one of the columns in the table
        $order_by_field = in_array($order_by_field, $modelClass::getModel()->getConnection()->getSchemaBuilder()->getColumnListing($modelClass::getModel()->getTable())) ? $order_by_field : 'id';
        $order_by_direction = in_array($order_by_direction, ['asc', 'desc']) ? $order_by_direction : 'asc';

        return $modelClass::orderBy($order_by_field, $order_by_direction);
    }

}
