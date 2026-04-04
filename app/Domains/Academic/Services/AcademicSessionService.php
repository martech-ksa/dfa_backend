<?php

namespace App\Domains\Academic\Services;

use App\Models\AcademicSession;

class AcademicSessionService
{

    public function getCurrentSession()
    {
        return AcademicSession::where('is_current',1)->first();
    }

}