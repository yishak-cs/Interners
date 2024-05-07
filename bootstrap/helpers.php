<?php

use App\Models\Internship;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * send the application accepted mail to applicant's
 *
 * @param \App\Models\User $user
 * @return bool
 */
function sendApplicationAcceptedMail(User $user): bool
{
    try {
        Mail::to($user->email)->send(new \App\Mail\ApplicationAccepted());
        return true;
    } catch (\Throwable $exception) {
        Log::error($exception->getMessage());
        return false;
    }
}


/**
 * send the internship started mail to intern's
 *
 * @param \App\Models\Internship $internship
 * @return bool
 */
function sendInternshipStartedMail(Internship $internship): bool
{
    try {
        $interns = $internship->getInterns();
        foreach($interns as $intern){
            Mail::to($intern->email)->send(new \App\Mail\InternshipStart($internship));
        }
        return true;
    } catch (\Throwable $exception) {
        Log::error($exception->getMessage());
        return false;
    }
}


