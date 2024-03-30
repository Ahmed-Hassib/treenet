<?php

/**
 * 
 */
function get_page_dependencies($page_role, $file_type)
{
  // include_once "app-routes.php";
  // website files
  $project_files_archeticture = [
    // global files
    'global' => [
      'css' => [
        '1' => 'normalize.css',
        '2' => 'animation.css',
        '3' => 'global.css',
        '4' => 'sidebar-menu.css',
      ],
      'js' => [
        '1' => 'lang.js',
        '2' => 'global.js',
        '3' => 'validation.js',
        '4' => 'validation_.js',
        '5' => 'sidebar-menu.js',
      ],
      'node' => [
        'css' => [
          '1' => 'bootstrap/dist/css/bootstrap.min.css',
          '2' => 'bootstrap-icons/font/bootstrap-icons.min.css',
        ],
        'js' => [
          '1' => 'jquery/dist/jquery.min.js',
          '2' => 'bootstrap/dist/js/bootstrap.bundle.min.js',
          '3' => 'progresspiesvg/js/min/jquery-progresspiesvg-min.js',
          '4' => 'progresspiesvg/js/min/progresspiesvgAppl-min.js',
        ]
      ],
      'fonts' => [
        '1' => 'cairo.css'
      ]
    ],

    // for tables files
    'tables' => [
      'css' => [
        '1' => 'table-style.css',
      ],
      'js' => [
        '1' => 'table-behaviour.js',
      ],
      'node' => [
        'css' => [
          '1' => "datatables.net-bs5/css/dataTables.bootstrap5.min.css",
          '2' => 'datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css',
          '3' => 'datatables.net-colresize-unofficial/jquery.dataTables.colResize.css'
        ],
        'js' => [
          '1' => 'jszip/dist/jszip.min.js',
          '2' => 'pdfmake/build/pdfmake.min.js',
          '3' => 'pdfmake/build/vfs_fonts.js',
          '4' => 'datatables.net/js/jquery.dataTables.min.js',
          '5' => 'datatables.net-bs5/js/dataTables.bootstrap5.min.js',
          '6' => 'datatables.net-buttons/js/dataTables.buttons.min.js',
          '7' => 'datatables.net-buttons/js/buttons.colVis.js',
          '8' => 'datatables.net-buttons/js/buttons.html5.min.js',
          '9' => 'datatables.net-buttons/js/buttons.print.min.js',
          '10' => 'datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js',
          '11' => 'datatables.net-colresize-unofficial/jquery.dataTables.colResize.js'
        ]
      ],
      'fonts' => []
    ],

    // for charts files
    'charts' => [
      'css' => [
        '1' => 'charts.css',
      ],
      'js' => [
        '1' => 'charts.js',
      ],
      'node' => [
        'css' => [],
        'js' => [
          '1' => 'chart.js/dist/chart.umd.js'
        ]
      ],
      'fonts' => []
    ],

    // for blog login
    'treenet_global' => [
      'css' => [
        '1' => 'footer.css',
      ],
      'js' => [
        '1' => 'history.js',
      ],
      'footer' => [
        'user' => 'user-footer.php',
        'root' => 'root-footer.php'
      ],
      'navbar' => [
        'landing' => 'landing-navbar.php',
        'user' => 'user-navbar.php',
        'root' => 'root-navbar.php',
      ]
    ],

    'treenet_map' => [
      'css' => [],
      'js' => [
        '1' => 'treenet_map.js'
      ],
      'node' => [],
    ],

    // for landing page
    'treenet_landing' => [
      'css' => [
        '1' => 'landing.css'
      ],
      'js' => [
        '1' => 'landing.js'
      ]
    ],

    // for blog login
    'treenet_login' => [
      'css' => [
        '1' => 'login.css'
      ],
      'js' => [],
    ],

    'treenet_signup' => [
      'css' => [
        '1' => 'signup.css'
      ],
      'js' => [
        '1' => 'signup.js'
      ],
    ],

    'treenet_dash' => [
      'css' => [
        '1' => 'dashboard.css',
      ],
      'js' => [],
    ],

    'treenet_user' => [
      'css' => [
        '1' => 'users.css',
      ],
      'js' => [
        '1' => 'users.js',
      ],
    ],

    'treenet_devices' => [
      'css' => [],
      'js' => [
        '1' => 'devices.js',
      ],
    ],

    'treenet_pieces' => [
      'css' => [],
      'js' => [
        '1' => 'pieces.js',
        '2' => 'devices.js',
      ],
    ],

    'treenet_clients' => [
      'css' => [],
      'js' => [
        '1' => 'clients.js',
      ],
    ],

    'treenet_dir' => [
      'css' => [
        '1' => 'hierarchical-chart.css',
        '2' => 'directions.css'
      ],
      'js' => [
        '1' => 'directions.js',
      ],
    ],

    'treenet_malfunction' => [
      'css' => [
        '1' => 'malfunction.css',
        '2' => 'media-preview.css'
      ],
      'js' => [
        '1' => 'malfunction.js',
      ],
    ],

    'treenet_combination' => [
      'css' => [
        '1' => 'combination.css',
        '2' => 'media-preview.css'
      ],
      'js' => [
        '1' => 'combination.js'
      ],
    ],
    
    'treenet_reports' => [
      'css' => [
        '1' => 'reports.css'
      ],
      'js' => [
        // '1' => 'reports.js'
      ],
    ],

    'treenet_settings' => [
      'css' => [
        '1' => 'settings.css'
      ],
      'js' => [
        '1' => 'settings.js'
      ],
    ],

    'treenet_services' => [
      'css' => [
        '1' => 'services.css'
      ],
      'js' => [
        '1' => 'services.js'
      ],
    ],
    
    'treenet_payment' => [
      'css' => [
        '1' => 'payments.css'
      ],
      'js' => [],
    ],

    'treenet_comp' => [
      'css' => [
        '1' => 'comp-sugg.css',
        '2' => 'media-preview.css'
      ],
      'js' => [
        '1' => 'comp-sugg.js'
      ],
    ],

    'treenet_err' => [
      'css' => [
        '1' => 'errors.css'
      ],
      'js' => [],
    ],

    'treenet_root' => [
      'css' => [],
      'js' => [
        '1' => 'root-global.js'
      ],
    ],
  ];
  // returns files of the given page role
  return key_exists($page_role, $project_files_archeticture) ? $project_files_archeticture[$page_role][$file_type] : null;
}
