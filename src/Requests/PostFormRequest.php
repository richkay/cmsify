<?php

namespace Cmsify\Requests;

use App\Http\Requests\Request;

class PostFormRequest extends Request
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
            'title' => 'required|min:3',
            'text' => 'required',
            'slug' => 'required_with:id|unique:cmsify_posts,slug,'.$this->get('id'),
            'categories' => config('cmsify.categories.disabled') ? '' : 'required',
        ];
    }
}
