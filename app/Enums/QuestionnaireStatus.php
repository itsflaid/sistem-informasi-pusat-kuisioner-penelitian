<?php

namespace App\Enums;

enum QuestionnaireStatus: string
{
    case Draft = 'draft';
    case Pending = 'pending';
    case Active = 'active';
    case Rejected = 'rejected';
    case Closed = 'closed';
}
