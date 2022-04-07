<?php

include_once 'config.php';
include_once 'src/Database.php';
include_once 'src/Utils.php';
include_once 'src/Migration/Types.php';
include_once 'src/Migration/Options.php';
include_once 'src/Migration/Migration.php';

$db = new Database($config);
$utils = new Utils;
$install = new Migration($db, $utils);

$users =
    [
        [
            'id',
            $install->types->Integer(),
            $install->options->UnSigned(),
            $install->options->NotNull(),
            $install->options->AutoIncrement()
        ],
        [
            'username',
            $install->types->String(25),
            $install->options->NotNull()
        ],
        [
            'password',
            $install->types->String(255),
            $install->options->NotNull()
        ],
        [
            'email',
            $install->types->String(255),
            $install->options->NotNull()
        ],
        [
            'is_online',
            $install->types->Boolean(),
            $install->options->NotNull(),
            $install->options->DefaultValue(0)
        ],
        [
            'is_admin',
            $install->types->Boolean(),
            $install->options->NotNull(),
            $install->options->DefaultValue(0)
        ],
        [
            'current_room',
            $install->types->Integer(),
            $install->options->NotNull(),
            $install->options->DefaultValue(0)
        ],
        [
            'failed_login',
            $install->types->Integer(),
            $install->options->NotNull(),
            $install->options->DefaultValue(0)
        ],
        [
            'last_login',
            $install->types->TimeStamp(),
            $install->options->NotNull(),
            $install->options->CurrentTimeStamp()
        ],

        [
            $install->options->PrimaryKey('id')
        ]
    ];

$rooms = [
    [
        'id',
        $install->types->Integer(),
        $install->options->UnSigned(),
        $install->options->NotNull(),
        $install->options->AutoIncrement()
    ],
    [
        'room_name',
        $install->types->String(255),
        $install->options->NotNull()
    ],
    [
        $install->options->PrimaryKey('id'),
    ],
];

$messages = [
    [
        'id',
        $install->types->Integer(),
        $install->options->UnSigned(),
        $install->options->NotNull(),
        $install->options->AutoIncrement()
    ],

    [
        'user',
        $install->types->Integer(),
        $install->options->NotNull()
    ],

    [
        'message',
        $install->types->Text(),
        $install->options->NotNull()
    ],

    [
        'encryption_key',
        $install->types->String(125),
        $install->options->NotNull()
    ],

    [
        'room_id',
        $install->types->Integer(),
        $install->options->UnSigned(),
        $install->options->NotNull(),
        $install->options->DefaultValue(1)
    ],

    [
        'date',
        $install->types->TimeStamp(),
        $install->options->NotNull()
    ],
    [
        $install->options->PrimaryKey('id'),
    ],
    [
        $install->options->Index('room_id'),
    ],
    [
        $install->options->Index('user'),
    ],
    [
        $install->options->ForeignKey("room_id", [
            'rooms' => 'id'
        ])
    ]
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $install->createTable("users", $users);

    $install->createTable("rooms", $rooms);

    $install->createTable("messages", $messages);

    $install->insertValue("users", [
        'username' => 'admin',
        'password' => password_hash('admin', PASSWORD_BCRYPT),
        'email' => 'admin@localhost.com',
        'is_admin' => 1
    ]);

    $install->insertValue('rooms', [
        'room_name' => 'General 😋'
    ]);

    // Generate Custom Encryption Key

    /* -------------------------- */

    $iv = $utils->random_str(16);

    $conf_file = "config.php";

    $conf_file_content = file_get_contents($conf_file);

    $conf_file_content = preg_replace("/iv_key/", $iv, $conf_file_content, 1);

    file_put_contents($conf_file, $conf_file_content);

    /* -------------------------- */

    $error = 1;
}
