<?php

namespace app\modules\journal\helpers;

class JournalHtmlHelper
{
    public static function getRecordCssClass($record)
    {
        $class = 'form-inline journal-mark';
        if ($record->typeObj->ticket) {
            return $class . '-with-ticket';
        }
        return $class;
    }
}