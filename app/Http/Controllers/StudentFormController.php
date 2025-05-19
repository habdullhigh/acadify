<?php

namespace App\Http\Controllers;

use App\Models\StudentForm;
use App\Http\Requests\StoreStudentFormRequest;
use App\Services\StudentFormService;
use App\Services\UploadService;

class StudentFormController extends Controller
{
    public function __construct(
        private readonly UploadService $uploadService,
        private readonly StudentFormService $studentFormService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentFormRequest $request)
    {
        $validatedData = $request->validated();

        $matricNo = $request->user()->matric_no;

        // Upload the file using the UploadService
        $filePath = $this->uploadService->uploadFile(
            $validatedData['form_file'],
            'student_form',
            $matricNo
        );
        // Create the student form record using the StudentFormService
        $this->studentFormService->createStudentForm($validatedData, $filePath);

        return response()->json(['message' => 'Student form created successfully.'], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show(StudentForm $studentForm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudentForm $studentForm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentForm $studentForm)
    {
        //
    }
    /**
     * Upload the form picture

     */
}
