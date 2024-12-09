<?php

namespace App\Helper;

use App\Models\Candidate;
use App\Models\MailTemplate;
use Exception;
use Illuminate\Support\Arr;

class FillRejectionMail
{
    protected Candidate $candidate;
    protected MailTemplate $mailTemplate;

    public function __construct(Candidate $candidate, MailTemplate $mailTemplate)
    {
        $this->candidate = $candidate;
        $this->mailTemplate = $mailTemplate;
    }

    public function fill()
    {
        $title = $this->mailTemplate->title;
        $content = $this->mailTemplate->content;
        $templateKeys = config('mailkey');
        preg_match_all('/\[\w*]/', $title . $content, $matches);
        $matches = array_unique(Arr::get($matches, '0', []));

        $cloneMatches = [];

        foreach ($matches as $match) {
            if (!isset($templateKeys[$match])) {
                continue;
            }

            $references = explode('.', $templateKeys[$match]['reference_value']);
            $data = $this->candidate;

            try {
                foreach ($references as $reference) {
                    $data = $data->{$reference};
                }

                $cloneMatches[$match] = $data;
            } catch (Exception $e) {
                $cloneMatches[$match] = '';
                throw $e;
            }
        }

        return [
            'title' => str_replace($matches, $cloneMatches, $title),
            'content' => str_replace($matches, $cloneMatches, $content),
        ];
    }
}
