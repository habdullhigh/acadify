<?php

namespace App\Enums;

enum OfficeEnum: string
{
    case HoD = 'Head of Department';
    case DepartmentalOffice = 'Departmental Office';
    case CollegeOffice = 'College Office';
    case Bursary = 'Bursary';
    case DSA = 'Dean of Students Affairs';
}
