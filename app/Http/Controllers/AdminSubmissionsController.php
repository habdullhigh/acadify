<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\StudentForm;
use App\Models\StudentReciept;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSubmissionsController extends Controller
{
    public function allSubmissions(Request $request)
    {
        $filter = $request->query('filter', 'all');

        $query = StudentForm::query();
        $query1 = StudentReciept::query();

        $query = match ($filter) {
            'pending' => $query->where('status', 'pending'),
            'approved' => $query->where('status', 'approved'),
            'rejected' => $query->where('status', 'rejected'),
            default => $query,
        };
        $query1 = match ($filter) {
            'pending' => $query1->where('status', 'pending'),
            'approved' => $query1->where('status', 'approved'),
            'rejected' => $query1->where('status', 'rejected'),
            default => $query1,
        };
        // Get the results
        $forms = $query->get();
        $reciepts = $query1->get();
        // Transform the results if needed
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
        // Return the results as JSON
        return response()->json([
            'forms' => $forms,
            'reciepts' => $reciepts,
        ]);


        return response()->json($query->get());
    }
    public function showOfficeSubmissions()
    {
        $officeId = Auth::user()->office_id;

        $forms = StudentForm::where('office_id', $officeId)->get()->transform(function ($form) {
            return [
                'id' => $form->id,
                'title' => $form->title,
                'status' => $form->status,
                'description' => $form->description,
                'target_office' => optional(Office::find($form->office_id))->name,
                'link' => $form->form_link,
                'created' => $form->created_at->format('Y-m-d H:i:s'),
                'updated' => $form->updated_at->format('Y-m-d H:i:s'),
            ];
        });

        $receipts = StudentReciept::where('office_id', $officeId)
            ->where('status', 'pending')
            ->get()
            ->transform(function ($receipt) {
                return [
                    'id' => $receipt->id,
                    'title' => $receipt->title,
                    'status' => $receipt->status,
                    'description' => $receipt->description,
                    'target_office' => optional(Office::find($receipt->office_id))->name,
                    'link' => $receipt->reciept_link,
                    'created' => $receipt->created_at->format('Y-m-d H:i:s'),
                    'updated' => $receipt->updated_at->format('Y-m-d H:i:s'),
                ];
            });

        return response()->json([
            'forms' => $forms,
            'reciepts' => $receipts,
        ]);
    }
    public function acceptSubmission(Request $request)
    {
        $request->validate([
            'submission_id' => 'required',
            'type' => 'required|string|in:form,reciept',
        ]);

        $submissionId = $request->input('submission_id');
        $type = $request->input('type');

        if ($type === 'form') {
            $submission = StudentForm::findOrFail($submissionId);
            if(Auth::user()->office_id !== $submission->office_id) {
                return response()->json(['message' => 'You are not authorized to approve this submission.'], 403);
            }
            if($submission->status !== 'pending') {
                return response()->json(['message' => 'Submission is not pending.'], 400);
            }
            // Check if the submission is already approved or rejected
            if ($submission->status === 'approved' || $submission->status === 'rejected') {
                return response()->json(['message' => 'Submission has already been processed.'], 400);
            }

            $submission->status = 'approved';
            $submission->save();
        } elseif ($type === 'receipt') {
            $submission = StudentReciept::findOrFail($submissionId);
            if(Auth::user()->office_id !== $submission->office_id) {
                return response()->json(['message' => 'You are not authorized to approve this submission.'], 403);
            }
            if($submission->status !== 'pending') {
                return response()->json(['message' => 'Submission is not pending.'], 400);
            }
            // Check if the submission is already approved or rejected
            if ($submission->status === 'approved' || $submission->status === 'rejected') {
                return response()->json(['message' => 'Submission has already been processed.'], 400);
            }
            $submission->status = 'approved';
            $submission->save();
        }
        return response()->json(['message' => 'Submission accepted successfully.']);
    }

    public function rejectSubmission(Request $request)
    {
        $request->validate([
            'submission_id' => 'required',
            'type' => 'required|string|in:form,reciept',
            'rejection_reason' => 'required|string|max:255',
        ]);

        $submissionId = $request->input('submission_id');
        $type = $request->input('type');

        if ($type === 'form') {
            $submission = StudentForm::findOrFail($submissionId);
            $submission->status = 'rejected';
            $submission->rejection_reason = $request->input('rejection_reason');
            $submission->save();
        } elseif ($type === 'receipt') {
            $submission = StudentReciept::findOrFail($submissionId);
            $submission->status = 'rejected';
            $submission->rejection_reason = $request->input('rejection_reason');
            $submission->save();
        }
        return response()->json(['message' => 'Submission rejected successfully.']);
    }
}

