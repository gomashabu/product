<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
//use lluminate\Validation\Validator;
use Illuminate\Contracts\Validation\Validator;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'artist' => 'required|string|max:40',
            'song' => 'required|string|max:50',
            'lyrics_with_chords' => 'max:65535',
            'flat_score' => 'max:65535'
        ];
    }
    
    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            if ($this->filled(['lyrics_with_chords', 'flat_score'])) {
                $validator->errors()->add(
                    'lyrics_with_chords', 'lyrics_with_chords と flat_score は両方記入できません。どちらか一方のみ記入してください。'
                );
            } elseif (!$this->anyFilled(['lyrics_with_chords', 'flat_score'])) {
                $validator->errors()->add(
                    'lyrics_with_chords', 'lyrics_with_chords と flat_score が空です。どちらか一方を記入してください。'
                );
            }
        });
    }
}
