<?php

namespace App\Http\Requests;

use App\Subject;
use Illuminate\Foundation\Http\FormRequest;
use Krucas\Notification\Facades\Notification;

class StoreFolderRequest extends FormRequest
{

    public function forbiddenResponse()
    {
        Notification::error('You are not authorized to create folder in this subject.');

        return redirect()->back();
    }


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $subject = resolve(Subject::class)->findOrFail($this->subject_id);

        return policy(Subject::class)->createFolder($this->user(), $subject);
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
