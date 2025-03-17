<?php

namespace App\Enums;

enum TableStatus: string
{
    case Pending = 'Còn Trống';
    case Avalaiable = 'Đang Chờ';
    case Unavaliable = 'Đã Đặt';
}
