<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);

include_once 'config.php';
include_once 'src/Database.php';
include_once 'src/Utility.php';
include_once 'src/Migration/Types.php';
include_once 'src/Migration/Options.php';
include_once 'src/Migration/Migration.php';

$db = new Database($config);
$utils = new Utility;
$install = new Migration($db, $utils);

$users =
    [
        [
            'id',
            Types::Integer(),
            Options::UnSigned(),
            Options::NotNull(),
            Options::AutoIncrement()
        ],
        [
            'username',
            Types::String(25),
            Options::NotNull()
        ],
        [
            'password',
            Types::String(255),
            Options::NotNull()
        ],
        [
            'email',
            Types::String(255),
            Options::NotNull()
        ],
        [
            'is_online',
            Types::Boolean(),
            Options::NotNull(),
            Options::DefaultValue(0)
        ],
        [
            'is_admin',
            Types::Boolean(),
            Options::NotNull(),
            Options::DefaultValue(0)
        ],
        [
            'current_room',
            Types::Integer(),
            Options::NotNull(),
            Options::DefaultValue(0)
        ],
        [
            'failed_login',
            Types::Integer(),
            Options::NotNull(),
            Options::DefaultValue(0)
        ],
        [
            'last_login',
            Types::TimeStamp(),
            Options::NotNull(),
            Options::CurrentTimeStamp()
        ],

        [
            Options::PrimaryKey('id')
        ]
    ];

$rooms = [
    [
        'id',
        Types::Integer(),
        Options::UnSigned(),
        Options::NotNull(),
        Options::AutoIncrement()
    ],
    [
        'room_name',
        Types::String(255),
        Options::NotNull()
    ],
    [
        Options::PrimaryKey('id'),
    ],
];

$messages = [
    [
        'id',
        Types::Integer(),
        Options::UnSigned(),
        Options::NotNull(),
        Options::AutoIncrement()
    ],

    [
        'user',
        Types::Integer(),
        Options::NotNull()
    ],

    [
        'message',
        Types::Text(),
        Options::NotNull()
    ],

    [
        'encryption_key',
        Types::String(125),
        Options::NotNull()
    ],

    [
        'room_id',
        Types::Integer(),
        Options::UnSigned(),
        Options::NotNull(),
        Options::DefaultValue(1)
    ],

    [
        'reciver_id',
        Types::Integer(),
        Options::UnSigned(),
        Options::NotNull(),
        Options::DefaultValue(0)
    ],

    [
        'date',
        Types::TimeStamp(),
        Options::NotNull()
    ],
    [
        Options::PrimaryKey('id'),
    ],
    [
        Options::Index('room_id'),
    ],
    [
        Options::Index('user'),
    ],
    [
        Options::Index('reciver_id'),
    ],
    [
        Options::ForeignKey("room_id", [
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
