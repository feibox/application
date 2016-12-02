<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFolderRequest extends FormRequest
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
        $this->uniqueRule();
        return [
            'name'      => [
                'alpha_num',
                'required',
                $this->uniqueRule(),
            ],
            'parent_id' => 'exists:folders,id',
        ];
    }


    private function uniqueRule()
    {
        $rule = resolve('Illuminate\Validation\Rule');
        $parent_id = $this->parent_id;
        $subject_id = $this->subject_id;
        return $rule->unique('folders')->where(function ($query) use ($subject_id, $parent_id) {
            $query->where('subject_id', $subject_id)->where('parent_id', $parent_id);
        });
    }
}
