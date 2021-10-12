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
            'Storage'       => 'array',
            'Storage.start' => 'required_with:Storage|string|in:"0", "250GB", "500GB", "1TB", "2TB", "3TB", "4TB", "8TB", "12TB", "24TB", "48TB", "72TB"',
            'Storage.end'   => 'required_with:Storage|string|in:"0", "250GB", "500GB", "1TB", "2TB", "3TB", "4TB", "8TB", "12TB", "24TB", "48TB", "72TB"',
            'Ram'           => 'array',
            'Ram.*'         => 'required_with:Ram|string|in:"2GB", "4GB", "8GB", "12GB", "16GB", "24GB", "32GB", "48GB", "64GB", "96GB"',
            'Harddisk'      => 'string|in:"SAS", "SATA", "SSD"',
            'Location'      => 'String'
        ];
    }
}
