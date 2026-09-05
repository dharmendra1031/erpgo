<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    protected $fillable = [
        'name',
        'type',
        'module',
        'created_by',
    ];

    public static $fieldTypes = [
        'text' => 'Text',
        'email' => 'Email',
        'number' => 'Number',
        'date' => 'Date',
        'textarea' => 'Textarea',
    ];

    public static $modules = [
        'user' => 'User',
        'customer' => 'Customer',
        'vendor' => 'Vendor',
        'product' => 'Product',
        'proposal' => 'Proposal',
        'Invoice' => 'Invoice',
        'Bill' => 'Bill',
        'account' => 'Account',
    ];

    public static function saveData($obj, $data)
    {

        if($data)
        {
            $RecordId = $obj->id;
            foreach($data as $fieldId => $value)
            {
                \DB::table('custom_field_values')->updateOrInsert(
                    ['record_id' => $RecordId, 'field_id' => $fieldId],
                    ['value' => $value, 'updated_at' => date('Y-m-d H:i:s')]
                );
            }
        }
    }

    public static function getData($obj, $module)
    {
        return \DB::table('custom_field_values')->select(
            [
                'custom_field_values.value',
                'custom_fields.id',
            ]
        )->join('custom_fields', 'custom_field_values.field_id', '=', 'custom_fields.id')->where('custom_fields.module', '=', $module)->where('record_id', '=', $obj->id)->get()->pluck('value', 'id');
    }
}
