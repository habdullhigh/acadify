<?php

namespace App\Http\Controllers;

use App\Models\StudentReciept;
use App\Http\Requests\StoreStudentRecieptRequest;
use App\Http\Requests\UpdateStudentRecieptRequest;
use App\Services\StudentRecieptService;
use App\Services\UploadService;

class StudentRecieptController extends Controller
{
    public function __construct(
        private readonly UploadService $uploadService,
        private readonly StudentRecieptService $studentRecieptService
    ){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRecieptRequest $request)
    {
        $validatedData = $request->validated();

        $matricNo = $request->user()->matric_no;

        // Upload the file using the UploadService
        $filePath = $this->uploadService->uploadFile(
            $validatedData['reciept_file'],
            'student_reciept',
            $matricNo
        );
        // Create the student form record using the StudentFormService
        $this->studentRecieptService->createStudentReciept($validatedData, $filePath);

        return response()->json(['message' => 'Student form created successfully.'], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(StudentReciept $studentReciept)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudentReciept $studentReciept)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRecieptRequest $request, StudentReciept $studentReciept)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentReciept $studentReciept)
    {
        //
    }
}
