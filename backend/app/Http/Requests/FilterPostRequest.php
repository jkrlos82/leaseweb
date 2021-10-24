<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'filters.Storage'       => 'array',
            'filters.Storage.start' => 'required_with:Storage|string',
            'filters.Storage.end'   => 'required_with:Storage|string',
            /* 'filters.Storage.start' => 'required_with:Storage|string|in:"0GB", "250GB", "500GB", "1TB", "2TB", "3TB", "4TB", "8TB", "12TB", "24TB", "48TB", "72TB"',
            'filters.Storage.end'   => 'required_with:Storage|string|in:"0GB", "250GB", "500GB", "1TB", "2TB", "3TB", "4TB", "8TB", "12TB", "24TB", "48TB", "72TB"', */
            'filters.RAM'           => 'array',
            'filters.RAM.*'         => 'string|in:"2GB", "4GB", "8GB", "12GB", "16GB", "24GB", "32GB", "48GB", "64GB", "96GB"',
            'filters.HardDisk_Type' => 'in:"SAS", "SATA", "SSD", ""',
            'filters.Location'      => 'nullable'
        ];
    }
}
