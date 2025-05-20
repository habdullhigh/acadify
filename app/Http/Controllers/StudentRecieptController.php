<?php

namespace App\Http\Controllers;

use App\Models\StudentReciept;
use App\Http\Requests\StoreStudentRecieptRequest;
use App\Http\Requests\UpdateStudentRecieptRequest;
use App\Models\Office;
use App\Services\StudentRecieptService;
use App\Services\UploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function getReciepts(Request $request)
    {
        $filter = $request->query('filter', 'all');

        $query = StudentReciept::where('user_id', Auth::id());

        $query = match ($filter) {
            'pending' => $query->where('status', 'pending'),
            'approved' => $query->where('status', 'approved'),
            'rejected' => $query->where('status', 'rejected'),
            default => $query,
        };

        $reciepts = $query->get()->transform(function ($reciept) {
            $reciept1 = [
                'id' => $reciept->id,
                'title' => $reciept->title,
                'status' => $reciept->status,
                'description' => $reciept->description,
            ];
            $reciept1['target_office'] = Office::where('id', $reciept->office_id)->first()->name;
            $reciept1['link'] = $reciept->reciept_link;
            $reciept1['created'] = $reciept->created_at->format('Y-m-d H:i:s');
            $reciept1['updated'] = $reciept->updated_at->format('Y-m-d H:i:s');

            return $reciept1;
        });

        return response()->json($reciepts);
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
