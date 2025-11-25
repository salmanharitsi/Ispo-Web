<?php

use Illuminate\Support\Facades\Request;

if (!function_exists('menuActive')) {
    function menuActive($route) {
        return Request::routeIs($route)
            ? 'bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg hover-lift'
            : 'text-gray-700 hover:bg-gradient-to-r group hover:from-green-50 hover:to-green-100 hover:text-green-700 transition-all duration-200 hover-lift';
    }
}

if (!function_exists('iconColor')) {
    function iconColor($route) {
        return Request::routeIs($route)
            ? 'text-white'
            : 'text-gray-500 group-hover:text-green-700';
    }
}

if (!function_exists('breadcrumb')) {
    function breadcrumb()
    {
        $route = request()->route()->getName();

        // Daftar label dan parent (jika ada)
        $breadcrumbs = [
            // Pekebun Breadcrumbs
            'pekebun' => [
                ['label' => 'Dashboard'],
            ],
            'pekebun.data-diri' => [
                ['label' => 'Data Diri'],
            ],
            'pekebun.daftar-kebun' => [
                ['label' => 'Daftar Kebun'],
            ],
            'pekebun.detail-data-kebun' => [
                ['label' => 'Daftar Kebun', 'route' => 'pekebun.daftar-kebun'],
                ['label' => 'Detail Data Kebun'],
            ],
            'pekebun.daftar-pemetaan' => [
                ['label' => 'Daftar Pemetaan'],
            ],
            'pekebun.pemetaan-kebun' => [
                ['label' => 'Daftar Pemetaan', 'route' => 'pekebun.daftar-pemetaan'],
                ['label' => 'Pemetaan Kebun'],
            ],
            'pekebun.allPemetaan' => [
                ['label' => 'Daftar Pemetaan', 'route' => 'pekebun.daftar-pemetaan'],
                ['label' => 'Semua Pemetaan'],
            ],
            'pekebun.daftar-kuisioner' => [
                ['label' => 'Daftar Kuisioner'],
            ],
            'pekebun.kuisioner-kebun' => [
                ['label' => 'Daftar Kuisioner', 'route' => 'pekebun.daftar-kuisioner'],
                ['label' => 'Kuisioner Kebun'],
            ],

            // Admin Breadcrumbs
            'admin' => [
                ['label' => 'Dashboard'],
            ],
        ];

        return $breadcrumbs[$route] ?? [
            ['label' => ucfirst(str_replace('-', ' ', $route))],
        ];
    }
}


