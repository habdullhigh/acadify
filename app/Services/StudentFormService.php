<?php

namespace App\Services;

use App\Http\Requests\StoreStudentFormRequest;
use App\Models\StudentForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StudentFormService
{

    public function createStudentForm($validatedData, string $filePath)
    {


        $studentForm = new StudentForm([
            'user_id' => Auth::id(),
            'office_id' => $validatedData['office_id'],
            'title' => $validatedData['title'],
            'status' => 'pending',
            'description' => 'Student form submitted by user',
        ]);

        $studentForm->form_link = $filePath;
        $studentForm->save();

        Log::channel('user')->info('User has performed an action', [
            'action' => 'uploaded a file',
            'response' => $studentForm,
            'link' => $filePath,
        ]);
    }
}
