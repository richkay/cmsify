<?php

namespace Cmsify\Requests;

use App\Http\Requests\Request;

class PostCreateRequest extends Request
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
        // !TODO: PostRequest Validations (categories:min:1 with exists!!!)
        return [
            'title' => 'required|min:3',
            'text' => 'required'
        ];
    }
}
