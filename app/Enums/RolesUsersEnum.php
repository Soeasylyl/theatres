<?php

namespace App\Enums;

use App\Traits\GetsAttributes;

enum RolesUsersEnum: string
{
    use GetsAttributes;

    #[Description('Супер администратор')]
    case SUPER_ADMIN = 'Super-Admin';
    #[Description('Администратор кинотеатра')]
    case CINEMA_ADMIN = 'cinema-admin';
    #[Description('Менеджер кинотеатра')]
    case CINEMA_MANAGER = 'cinema-manager';
    #[Description('Модератор')]
    case MODERATOR = 'moderator';
}
