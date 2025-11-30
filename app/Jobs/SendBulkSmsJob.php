<?php

namespace App\Jobs;

use App\Models\SmsLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendBulkSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $mobile;
    public $message;
    public $chamber_id;
    public $user_id;

    public function __construct($mobile, $message, $chamber_id, $user_id)
    {
        $this->mobile = $mobile;
        $this->message = $message;
        $this->chamber_id = $chamber_id;
        $this->user_id = $user_id;
    }

    public function handle()
    {
        $apiKey = "S52hHvOvP2rAEm2AUeQp";
        $senderId = "8809617615541";

        // Format mobile number
        $mobile = preg_replace('/[^0-9]/', '', $this->mobile);
        if (strlen($mobile) == 11) {
            $mobile = "88" . $mobile;
        }

        // Prepare API URL
        $url = "https://bulksmsbd.net/api/smsapi?api_key={$apiKey}&type=text&number={$mobile}&senderid={$senderId}&message=" . urlencode($this->message);

        // Send request using file_get_contents
        $response = @file_get_contents($url);

        $status = 'failed';
        $responseText = $response ?? 'NO RESPONSE';
        $responseCode = null;

        if ($response) {
            // Decode JSON response
            $res = json_decode($response, true);

            if ($res && isset($res['response_code'])) {
                $responseCode = $res['response_code'];

                if ($responseCode == 202) {
                    $status = 'success';
                }
            }
        }

        // Log SMS
        SmsLog::create([
            'mobile' => $this->mobile,
            'message' => $this->message,
            'status' => $status,
            'provider' => 'BulkSMSBD',
            'response' => $responseText,
            'chamber_id' => $this->chamber_id,
            'user_id' => $this->user_id
        ]);
    }
}
