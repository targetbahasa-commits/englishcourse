<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ClassPeriodUpsertRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Floor on the group size per batch type: Reguler >= 4, Semi-Private >= 2,
        // Private is exactly 1 (a 1-on-1 class can't hold more). Admins can raise
        // min_capacity above this floor per batch, but never below it.
        $minCapacityFloorByType = ['regular' => 4, 'semi_private' => 2, 'private' => 1];
        $batchType = $this->input('batch_type');
        $floor = $minCapacityFloorByType[$batchType] ?? 1;

        return [
            'name' => 'nullable|string|max:255',
            'program_id' => 'required|exists:programs,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:active,upcoming,closed',
            'learning_mode' => 'required|in:online,offline',
            'batch_type' => 'required|in:regular,semi_private,private',
            'batch_number' => 'nullable|integer|min:1',
            'teacher_id'   => 'nullable|exists:users,id',
            'min_capacity' => [
                'required',
                'integer',
                "min:{$floor}",
                function ($attribute, $value, $fail) use ($batchType) {
                    if ($batchType === 'private' && (int) $value !== 1) {
                        $fail('Batch Private harus memiliki jumlah minimal tepat 1 orang.');
                    }
                },
            ],
            'max_capacity' => [
                $batchType === 'private' ? 'required' : 'nullable',
                'integer',
                "min:{$floor}",
                function ($attribute, $value, $fail) use ($batchType) {
                    if ($value === null) {
                        return;
                    }
                    if ($batchType === 'private' && (int) $value !== 1) {
                        $fail('Batch Private harus memiliki kapasitas tepat 1 orang.');
                    }
                    $min = (int) $this->input('min_capacity');
                    if ($min && (int) $value < $min) {
                        $fail('Kapasitas maksimum tidak boleh lebih kecil dari jumlah minimal.');
                    }
                },
            ],
        ];
    }
}
