<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResepRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // only authenticated users may create reseps
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
        public function rules(): array
    {
        return [
            'judul'   => ['required', 'string', 'max:255'],
            'bahan'   => ['required', 'string'],
            'langkah' => ['required', 'string'],
            'gambar'  => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }

        public function messages(): array
    {
        return [
            'langkah.required' => 'Langkah-langkah memasak wajib diisi ya!',
            // pesan lain jika perlu
        ];
    }

        public function store(StoreResepRequest $request)
    {
        $data = $request->validated();

        dd($data);

    }
    }
