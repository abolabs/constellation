<?php

return [
    'level' => [
        1 => 'Faible',
        2 => 'Majeur',
        3 => 'Critique',
    ],
    'level_description' => [
        1 => 'En cas d\'indisponibilité : impact sur fonctionnalité(s) mineure(s) ou majeure(s) avec solution de contournement',
        2 => 'En cas d\'indisponibilité : impact sur fonctionnalité(s) majeure(s) sans solution de contournement mais sans indisponibilité générale',
        3 => 'En cas d\'indisponibilité : impact de fonctionnalité(s) majeure(s) sans solution de contournement entrainant une indisponibilité générale de l\'application'
    ],
    'level_badge' => [
        1 => 'badge-success',
        2 => 'badge-warning',
        3 => 'badge-danger',
    ]
];
