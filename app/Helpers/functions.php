<?php

use Illuminate\Support\Facades\Auth;

if(!function_exists('get_data_user'))
{
    function get_data_user($type, $field = 'id')
    {
        return Auth::guard($type)->user() ? Auth::guard($type)->user()->$field : '';
    }
}

if(!function_exists('data_tree'))
{
    function data_tree($data, $parent_id = 0, $level = 0)
    {
        $result = [];
        foreach($data as $item)
        {
            if($item['parent_id'] == $parent_id)
            {
                $result[] = $item;
                $item['level'] = $level;

                $child = data_tree($data, $item['id'], $level + 1);
                $result = array_merge($result, $child);
            }
        }

        return $result;
    }
}