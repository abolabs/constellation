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
        3 => 'En cas d\'indisponibilité : impact de fonctionnalité(s) majeure(s) sans solution de contournement entrainant une indisponibilité générale de l\'application',
    ],
    'level_bg' => [
        1 => 'success',
        2 => 'warning',
        3 => 'danger',
    ],
    'not_found' => 'Dépendance d\'instance de service introuvable.',
];
