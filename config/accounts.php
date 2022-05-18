<?php

return [
    /*
     * defines which email addresses are allowed.
     *
     * The given strings are checked against the email a user chooses to register with.
     * Regex is supported.
     *
     * no entries results in allowing all emails which aren't blocked by the blacklist.
     *
     */
    "email_whitelist" => [
        "^.*jade-hs.de$"
    ],

    /*
     * defines which email addresses are permitted.
     *
     * The given strings are checked against the email a user chooses to register with and are allowed by the whitelist.
     * Regex is supported.
     */
    "email_blacklist" => [
    ],

    /*
     * if set to true, the email filter is enabled. Otherwise the filters are ignored
     */
    "disable_filter" => env("EMAIL_FILTER_DISABLED", false)
];
