<?php
require 'config.php'; // Make sure this connects to MongoDB
require 'functions.php'; // For sanitize() if needed

$usersCollection = $db->users;

// Sample users
$sampleUsers = [
    [
        'username' => 'johncrew',
        'email' => 'john@joyson.com',
        'password' => password_hash('password123', PASSWORD_DEFAULT),
        'role' => 'user',
        'verified' => true
    ],
    [
        'username' => 'marycrew',
        'email' => 'mary@joyson.com',
        'password' => password_hash('mypassword', PASSWORD_DEFAULT),
        'role' => 'user',
        'verified' => true
    ],
    [
        'username' => 'petercrew',
        'email' => 'peter@joyson.com',
        'password' => password_hash('letmein', PASSWORD_DEFAULT),
        'role' => 'user',
        'verified' => true
    ]
];

foreach ($sampleUsers as $user) {
    $existing = $usersCollection->findOne(['email' => $user['email']]);
    if (!$existing) {
        $usersCollection->insertOne($user);
        echo "Inserted user: {$user['username']} ({$user['email']})\n";
    } else {
        echo "User {$user['username']} already exists.\n";
    }
}

echo "User setup complete.\n";
