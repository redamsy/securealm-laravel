<?php

namespace App\Enums;

enum BloodTypeEnum:string {
    case APositive = 'A positive (A+)';
    case ANegative = 'A negative (A-)';
    case BPositive = 'B positive (B+)';
    case BNegative = 'B negative (B-)';
    case ABPositive = 'AB positive (AB+)';
    case ABNegative = 'AB negative (AB-)';
    case OPositive = 'O positive (O+)';
    case ONegative ='O negative (O-)';
}
