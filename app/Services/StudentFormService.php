<?php

namespace App\Services;

use App\Http\Requests\StoreStudentFormRequest;
use App\Models\StudentForm;
use Illuminate\Support\Facades\Log;

class StudentFormService{

    public function createStudentForm(StoreStudentFormRequest $validatedData, string $filePath)
    {


        // Create the student form record
        return StudentForm::create([
            'student_form_link' => $filePath,
            'user_id' => $validatedData->user()->id,
            'office_id' => $validatedData['office_id'],
            'title' => $validatedData['title'],
            'status' => 'pending',
            'description' => $validatedData['description'],
        ]);

        Log::channel('user')->info('User has performed an action', [
            'user_id' => $validatedData->user()->id,
            'action' => 'uploaded a file',
        ]);
    }
}
