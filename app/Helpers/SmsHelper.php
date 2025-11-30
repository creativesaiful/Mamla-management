<?php

if (!function_exists('sms_response_text')) {
    function sms_response_text($code)
    {
        $messages = [
            202  => "SMS Submitted Successfully",
            1001 => "Invalid Number",
            1002 => "Sender ID incorrect or disabled",
            1003 => "Missing required fields",
            1005 => "Internal Server Error",
            1006 => "Balance Validity Not Available",
            1007 => "Balance Insufficient",
            1011 => "User ID not found",
            1012 => "Masking SMS must be sent in Bengali",
            1013 => "Sender ID missing in gateway",
            1014 => "Sender Type Name not found",
            1015 => "No valid gateway found for this sender",
            1016 => "Sender Price info inactive",
            1017 => "Sender Type Price info missing",
            1018 => "Account disabled",
            1019 => "Sender price disabled",
            1020 => "Parent account not found",
            1021 => "Parent active price missing",
            1031 => "Account not verified",
            1032 => "IP not whitelisted",
        ];

        return $messages[$code] ?? "Unknown Error";
    }
}
