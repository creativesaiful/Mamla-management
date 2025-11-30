<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CaseDiary;
use App\Models\Date;
use App\Jobs\SendBulkSmsJob;
use App\Models\SmsLog;


class SmsController extends Controller
{
    public function sendSmsBulk(Request $request)
    {
        $request->validate([
            'mobiles' => 'required',
            'sms_text' => 'required'
        ]);

        $selectedMobiles = explode(',', $request->mobiles);

        foreach ($selectedMobiles as $mobile) {

            $caseDiary = CaseDiary::where('client_mobile', $mobile)->first();

            if (!$caseDiary) {
                continue;
            }

            $caseNo = $caseDiary->case_number;

            $nextDate = Date::where('case_id', $caseDiary->id)
                ->where('next_date', '>', today())
                ->orderBy('next_date', 'asc')
                ->first();

            $formattedDate = $nextDate ? $nextDate->next_date->format('d-m-Y') : "Not Set";

            $smsText = str_replace(
                ['[case]', '[date]'],
                [$caseNo, $formattedDate],
                $request->sms_text
            );

            
            // Dispatch Asynchronous Job
            dispatch(new SendBulkSmsJob(
                $mobile,
                $smsText,
                auth()->user()->chamber_id,
                auth()->user()->id
            ));
        }

        return back()->with('success', 'SMS queued — delivering soon.');
    }


    public function messages()
{
    // Fetch all SMS logs for the user's chamber
    $messages = SmsLog::where('chamber_id', auth()->user()->chamber_id)
        ->with('user') // eager load user to avoid N+1
        ->orderBy('created_at', 'desc')
        ->get(); // get() instead of paginate(), let DataTables handle pagination

    return view('sms.messages', compact('messages'));
}

}
