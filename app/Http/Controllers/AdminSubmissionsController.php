<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\StudentForm;
use App\Models\StudentReciept;
use Illuminate\Http\Request;

class AdminSubmissionsController extends Controller
{
    public function allSubmissions(Request $request)
    {
        $filter = $request->query('filter', 'all');

        $query = StudentForm::query();
        $query1 =StudentReciept::query();

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
}
