<?php

namespace App\Enums;

use App\Traits\GetsAttributes;

enum PermissionsUsersEnum: string
{
    use GetsAttributes;

    #[Description('Управление кинотеатром')]
    case MANAGE_CINEMA = 'manage-cinema';
    #[Description('Управление залами')]
    case MANAGE_HALLS = 'manage-halls';
    #[Description('Управление сеансами')]
    case MANAGE_SCREENINGS = 'manage-screening';
    #[Description('Управление ценами')]
    case MANAGE_PRICES = 'manage-prices';
    #[Description('Управление местами')]
    case MANAGE_SEATS = 'manage-seats';
    #[Description('Управление пользователями')]
    case MANAGE_USERS = 'manage-users';
    #[Description('Управление фильмами')]
    case MANAGE_MOVIES = 'manage_movies';
    #[Description('Управление администраторами')]
    case MANAGE_ADMINS = 'manage-admins';
    #[Description('Просмотр административной панели')]
    case VIEW_ADMIN_PANEL = 'view-partials';
}
