<?php

namespace App\Services;

use App\Models\StudentReciept;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StudentRecieptService {

    public function createStudentReciept($validatedData, string $filePath)
    {
        $studentReciept = new StudentReciept([
            'user_id' => Auth::id(),
            'office_id' => $validatedData['office_id'],
            'title' => $validatedData['title'],
            'status' => 'pending',
            'description' => 'Student reciept submitted by user',
        ]);

        $studentReciept->reciept_link = $filePath;
        $studentReciept->save();

        Log::channel('user')->info('User has performed an action', [
            'action' => 'uploaded a file',
            'response' => $studentReciept,
            'link' => $filePath,
        ]);
    }
}
