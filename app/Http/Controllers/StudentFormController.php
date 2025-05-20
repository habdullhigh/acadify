<?php

namespace App\Http\Controllers;

use App\Models\StudentForm;
use App\Http\Requests\StoreStudentFormRequest;
use App\Models\Office;
use App\Services\StudentFormService;
use App\Services\UploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function getForms(Request $request)
    {
        $filter = $request->query('filter', 'all');

        $query = StudentForm::where('user_id', Auth::id());

        $query = match ($filter) {
            'pending' => $query->where('status', 'pending'),
            'approved' => $query->where('status', 'approved'),
            'rejected' => $query->where('status', 'rejected'),
            default => $query,
        };

        $forms = $query->get()->transform(function ($form) {
            $form1 = [
                'id' => $form->id,
                'title' => $form->title,
                'status' => $form->status,
                'description' => $form->description,

            ];
            $form1['target_office'] = Office::where('id', $form->office_id)->first()->name;
            $form1['link'] = $form->form_link;
            $form1['created'] = $form->created_at->format('Y-m-d H:i:s');
            $form1['updated'] = $form->updated_at->format('Y-m-d H:i:s');
            return $form1;
        });

        return response()->json([
            'forms' => $forms,
            'message' => 'Student forms retrieved successfully.',
        ], 200);
    }


    /**
     * Display the specified resource.
     */
    public function show(StudentForm $studentForm) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudentForm $studentForm) {}

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentForm $studentForm) {}
    /**
     * Upload the form picture

     */
}
