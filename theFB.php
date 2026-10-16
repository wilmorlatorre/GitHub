<?php
// Start session to store dynamic wall posts and poke counter
session_start();

// Initialize wall posts if not set
if (!isset($_SESSION['wall_posts'])) {
    $_SESSION['wall_posts'] = [
        [
            'author' => 'Eduardo Saverin',
            'time'   => 'Today at 2:14 AM',
            'text'   => 'Hey Mark, did you push the updated advertising algorithm to the server yet? Need to check with the guys in New York.',
            'img'    => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=faces'
        ],
        [
            'author' => 'Dustin Moskovitz',
            'time'   => 'Yesterday at 11:42 PM',
            'text'   => 'Kirkland dining hall is officially closed. Coffee run to Adams House if anyone is still awake writing code.',
            'img'    => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&h=100&fit=crop&crop=faces'
        ],
        [
            'author' => 'Chris Hughes',
            'time'   => 'Oct 14 at 4:10 PM',
            'text'   => 'Columbia and Stanford rollout looks good! Server load is holding steady so far.',
            'img'    => 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?w=100&h=100&fit=crop&crop=faces'
        ]
    ];
}

// Initialize poke count
if (!isset($_SESSION['poke_count'])) {
    $_SESSION['poke_count'] = 42;
}

// Handle Form Submissions (POST)
$notice_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add_wall_post') {
        $author = trim($_POST['author'] ?? 'Anonymous Harvardian');
        $message = trim($_POST['message'] ?? '');
        
        if (!empty($message)) {
            array_unshift($_SESSION['wall_posts'], [
                'author' => htmlspecialchars($author, ENT_QUOTES, 'UTF-8'),
                'time'   => 'Just now (' . date('g:i A') . ')',
                'text'   => htmlspecialchars($message, ENT_QUOTES, 'UTF-8'),
                'img'    => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&h=100&fit=crop&crop=faces'
            ]);
            $notice_message = 'Your message has been posted to Mark\'s Wall.';
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'poke') {
        $_SESSION['poke_count']++;
        $notice_message = 'You just poked Mark Zuckerberg!';
    }
}

// Profile metadata
$user = [
    'name'           => 'Mark Zuckerberg',
    'status'         => 'hacking on php and mysql in kirkland h-33...',
    'network'        => 'Harvard [Student]',
    'relationship'   => 'In an open relationship',
    'birthday'       => 'May 14, 1984',
    'hometown'       => 'Dobbs Ferry, NY',
    'residence'      => 'Kirkland House H-33',
    'concentration'  => 'Computer Science, Psychology',
    'high_school'    => 'Phillips Exeter Academy \'02',
    'screenname'     => 'the_zuck (AIM)',
    'website'        => 'http://www.thefacebook.com',
    'classes'        => 'CS50, CS51, Psych 1, Math 55a',
    'interests'      => 'Open source, peer-to-peer networks, eliminating degrees of separation, Red Bull, Latin classics',
    'music'          => 'Green Day, Daft Punk, Beck, Jay-Z, Shakira, Nirvana',
    'favorite_quote' => '"Fortune favors the bold." - Virgil'
];

// Friends list
$friends = [
    ['name' => 'Eduardo Saverin', 'img' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=120&h=120&fit=crop&crop=faces'],
    ['name' => 'Dustin Moskovitz', 'img' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=120&h=120&fit=crop&crop=faces'],
    ['name' => 'Chris Hughes', 'img' => 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?w=120&h=120&fit=crop&crop=faces'],
    ['name' => 'Andrew McCollum', 'img' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=120&h=120&fit=crop&crop=faces'],
    ['name' => 'Priscilla Chan', 'img' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=120&h=120&fit=crop&crop=faces'],
    ['name' => 'Sean Parker', 'img' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=120&h=120&fit=crop&crop=faces']
];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!-- Mobile Viewport optimization -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>[thefacebook] :: <?= htmlspecialchars($user['name']); ?>'s Profile</title>
    <style type="text/css">
        /* Classic 2004-2005 TheFacebook Styles */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            font-family: "Lucida Grande", Tahoma, Verdana, Arial, sans-serif;
            font-size: 11px;
            color: #000000;
        }

        a {
            color: #3b5998;
            text-decoration: underline;
        }

        a:hover {
            color: #112266;
            text-decoration: underline;
        }

        /* Top Blue Header */
        #header {
            background-color: #3b5998;
            border-bottom: 2px solid #2b4270;
            color: #ffffff;
            min-height: 38px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 15px;
            flex-wrap: wrap;
        }

        .logo {
            font-family: Georgia, "Times New Roman", Times, serif;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: -1px;
            color: #ffffff;
            text-decoration: none;
            padding: 4px 0;
        }

        .logo:hover {
            text-decoration: none;
            color: #e0e8f8;
        }

        .header-nav {
            font-size: 11px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }

        .header-nav a {
            color: #dbe3f3;
            text-decoration: none;
            margin-left: 12px;
            font-weight: bold;
            white-space: nowrap;
        }

        .header-nav a:hover {
            text-decoration: underline;
            color: #ffffff;
        }

        /* Subheader Bar */
        #sub-header {
            background-color: #6d84b4;
            padding: 5px 15px;
            border-bottom: 1px solid #3b5998;
            color: #ffffff;
            font-size: 10px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 4px;
        }

        #sub-header a {
            color: #ffffff;
            text-decoration: none;
        }

        /* Page Layout Container */
        #container {
            width: 820px;
            margin: 0 auto;
            padding: 10px 0;
            display: flex;
            gap: 12px;
        }

        /* Sidebar Column */
        #sidebar-left {
            width: 170px;
            flex-shrink: 0;
        }

        /* Main Content Column */
        #content-center {
            width: 440px;
            flex-shrink: 0;
        }

        /* Right Column */
        #sidebar-right {
            width: 190px;
            flex-shrink: 0;
        }

        /* Standard TheFacebook Box */
        .box {
            border: 1px solid #d8dfea;
            margin-bottom: 10px;
            background: #ffffff;
        }

        .box-header {
            background-color: #eceff5;
            border-bottom: 1px solid #d8dfea;
            padding: 4px 7px;
            font-weight: bold;
            color: #333333;
            font-size: 11px;
        }

        .box-body {
            padding: 8px;
        }

        /* Profile Picture & Left Menus */
        .profile-pic {
            border: 1px solid #999999;
            padding: 2px;
            background: #ffffff;
            display: block;
            margin: 0 auto 8px auto;
            width: 154px;
            height: 180px;
            object-fit: cover;
        }

        .action-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .action-list li {
            padding: 4px 0;
            border-bottom: 1px solid #eeeeee;
        }

        .action-list li:last-child {
            border-bottom: none;
        }

        .action-list a, .action-list button.link-btn {
            background: none;
            border: none;
            padding: 0;
            font-family: inherit;
            font-size: 11px;
            color: #3b5998;
            cursor: pointer;
            text-decoration: underline;
        }

        .action-list button.link-btn:hover {
            color: #112266;
        }

        /* User Header Banner */
        .profile-name-bar {
            border-bottom: 1px solid #3b5998;
            padding-bottom: 4px;
            margin-bottom: 8px;
        }

        .profile-name {
            font-size: 16px;
            font-weight: bold;
            color: #3b5998;
            margin: 0;
        }

        .profile-status {
            font-style: italic;
            color: #555555;
            margin-top: 2px;
            font-size: 11px;
        }

        /* Information Tables */
        table.info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }

        table.info-table td {
            padding: 3px 4px;
            vertical-align: top;
            font-size: 11px;
        }

        table.info-table td.label {
            color: #666666;
            width: 90px;
            text-align: right;
            font-weight: bold;
            padding-right: 8px;
        }

        /* Wall Section */
        .wall-input-box {
            background: #f7f7f7;
            border: 1px solid #cccccc;
            padding: 8px;
            margin-bottom: 10px;
        }

        .wall-input-box textarea {
            width: 100%;
            height: 52px;
            font-family: inherit;
            font-size: 11px;
            border: 1px solid #999999;
            padding: 5px;
            display: block;
            margin-bottom: 5px;
            resize: vertical;
        }

        .wall-btn {
            background: #eceff5;
            border: 1px solid #999999;
            font-size: 11px;
            padding: 4px 10px;
            cursor: pointer;
            font-weight: bold;
            color: #3b5998;
        }

        .wall-btn:hover {
            background: #d8dfea;
        }

        .wall-post {
            border-top: 1px dashed #d8dfea;
            padding: 8px 0;
            display: flex;
            gap: 8px;
        }

        .wall-post:first-child {
            border-top: none;
        }

        .wall-avatar {
            width: 38px;
            height: 38px;
            border: 1px solid #cccccc;
            object-fit: cover;
            flex-shrink: 0;
        }

        .wall-body {
            flex: 1;
        }

        .wall-author {
            font-weight: bold;
            color: #3b5998;
        }

        .wall-meta {
            color: #888888;
            font-size: 9px;
            margin-bottom: 4px;
        }

        .wall-content {
            line-height: 1.35em;
            word-break: break-word;
        }

        /* Friends Grid */
        .friends-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 6px;
            text-align: center;
        }

        .friend-card img {
            width: 50px;
            height: 50px;
            border: 1px solid #cccccc;
            object-fit: cover;
            display: block;
            margin: 0 auto 2px auto;
        }

        .friend-card .name {
            font-size: 9px;
            color: #3b5998;
            line-height: 1.1em;
            word-break: break-word;
        }

        /* Alert notification */
        .system-notice {
            background: #fff8cc;
            border: 1px solid #e2cb82;
            padding: 6px 10px;
            margin-bottom: 10px;
            font-weight: bold;
            color: #4a4000;
        }

        /* Classic Footer */
        #footer {
            border-top: 1px solid #d8dfea;
            text-align: center;
            padding: 15px 10px;
            font-size: 10px;
            color: #777777;
            margin-top: 20px;
        }

        #footer a {
            color: #3b5998;
            margin: 0 4px;
            text-decoration: none;
        }

        /* ========================================================
           RESPONSIVE MOBILE VIEW (VERTICAL / PORTRAIT PHONE SCREENS)
           ======================================================== */
        @media screen and (max-width: 768px) {
            #header {
                flex-direction: column;
                align-items: flex-start;
                padding: 6px 10px;
            }

            .header-nav {
                width: 100%;
                overflow-x: auto;
                white-space: nowrap;
                padding-bottom: 4px;
                margin-top: 4px;
                -webkit-overflow-scrolling: touch;
            }

            .header-nav a {
                margin-left: 0;
                margin-right: 12px;
                font-size: 11px;
            }

            #sub-header {
                font-size: 9px;
                padding: 6px 10px;
            }

            /* Stack 3-column desktop layout vertically */
            #container {
                width: 100%;
                max-width: 100%;
                flex-direction: column;
                padding: 8px;
                gap: 0;
            }

            /* Natural mobile reading order:
               1. Content header & info
               2. Left sidebar (picture & quick actions)
               3. Wall & details
               4. Right sidebar (friends & ads)
            */
            #content-center {
                width: 100%;
                order: 1;
            }

            #sidebar-left {
                width: 100%;
                order: 2;
            }

            #sidebar-right {
                width: 100%;
                order: 3;
            }

            .profile-pic {
                width: 130px;
                height: 150px;
            }

            /* Better tap targets on touch devices */
            .action-list li {
                padding: 6px 0;
            }

            .action-list a, .action-list button.link-btn {
                font-size: 12px;
            }

            table.info-table td.label {
                width: 80px;
                font-size: 10.5px;
            }

            /* Adjust friends grid for small screens */
            .friends-grid {
                grid-template-columns: repeat(4, 1fr);
                gap: 8px;
            }

            .friend-card img {
                width: 55px;
                height: 55px;
            }

            .wall-btn {
                width: 100%;
                padding: 6px;
            }
        }
    </style>
</head>
<body>

    <!-- Top Blue Header -->
    <div id="header">
        <a href="index.php" class="logo">[thefacebook]</a>
        <div class="header-nav">
            <a href="#">welcome</a>
            <a href="#">search</a>
            <a href="#">browse</a>
            <a href="#">my profile</a>
            <a href="#">my friends</a>
            <a href="#">my groups</a>
            <a href="#">messages</a>
            <a href="#">account</a>
            <a href="#">logout</a>
        </div>
    </div>

    <!-- Subheader Notification Bar -->
    <div id="sub-header">
        <span>Logged in as <b>Guest Student</b> (Harvard)</span>
        <span>The Facebook connects college networks.</span>
    </div>

    <!-- Main Container -->
    <div id="container">

        <!-- CENTER CONTENT (Ranked first on mobile via flex order) -->
        <div id="content-center">
            <?php if (!empty($notice_message)): ?>
                <div class="system-notice">
                    ✓ <?= htmlspecialchars($notice_message); ?>
                </div>
            <?php endif; ?>

            <div class="profile-name-bar">
                <h1 class="profile-name"><?= htmlspecialchars($user['name']); ?></h1>
                <div class="profile-status"><?= htmlspecialchars($user['status']); ?></div>
            </div>

            <!-- Information Box -->
            <div class="box">
                <div class="box-header">Information</div>
                <div class="box-body">
                    <div style="font-weight: bold; border-bottom: 1px solid #eeeeee; margin: 4px 0 6px 0; color: #3b5998;">Account Info:</div>
                    <table class="info-table">
                        <tr><td class="label">Name:</td><td><?= htmlspecialchars($user['name']); ?></td></tr>
                        <tr><td class="label">Member Since:</td><td>February 4, 2004</td></tr>
                        <tr><td class="label">Last Update:</td><td>October 16, 2004</td></tr>
                        <tr><td class="label">Status:</td><td><?= htmlspecialchars($user['network']); ?></td></tr>
                        <tr><td class="label">Relationship:</td><td><?= htmlspecialchars($user['relationship']); ?></td></tr>
                        <tr><td class="label">Birthday:</td><td><?= htmlspecialchars($user['birthday']); ?></td></tr>
                        <tr><td class="label">Hometown:</td><td><?= htmlspecialchars($user['hometown']); ?></td></tr>
                    </table>

                    <div style="font-weight: bold; border-bottom: 1px solid #eeeeee; margin: 10px 0 6px 0; color: #3b5998;">Education Info:</div>
                    <table class="info-table">
                        <tr><td class="label">College:</td><td>Harvard '06</td></tr>
                        <tr><td class="label">Concentration:</td><td><?= htmlspecialchars($user['concentration']); ?></td></tr>
                        <tr><td class="label">Classes:</td><td><?= htmlspecialchars($user['classes']); ?></td></tr>
                        <tr><td class="label">High School:</td><td><?= htmlspecialchars($user['high_school']); ?></td></tr>
                    </table>

                    <div style="font-weight: bold; border-bottom: 1px solid #eeeeee; margin: 10px 0 6px 0; color: #3b5998;">Personal Info:</div>
                    <table class="info-table">
                        <tr><td class="label">Interests:</td><td><?= htmlspecialchars($user['interests']); ?></td></tr>
                        <tr><td class="label">Favorite Music:</td><td><?= htmlspecialchars($user['music']); ?></td></tr>
                        <tr><td class="label">Quote:</td><td><?= htmlspecialchars($user['favorite_quote']); ?></td></tr>
                    </table>
                </div>
            </div>

            <!-- Wall Section -->
            <div class="box" id="wall">
                <div class="box-header">The Wall (<?= count($_SESSION['wall_posts']); ?> posts)</div>
                <div class="box-body">
                    <!-- Wall Posting Form -->
                    <div class="wall-input-box">
                        <form method="post" action="#wall">
                            <input type="hidden" name="action" value="add_wall_post" />
                            <div style="margin-bottom: 4px;">
                                <label style="font-weight: bold; font-size: 10px;">Post something to Mark's wall:</label>
                            </div>
                            <textarea name="message" placeholder="Write a message on Mark's wall..." required></textarea>
                            <div style="text-align: right;">
                                <button type="submit" class="wall-btn">Post to Wall</button>
                            </div>
                        </form>
                    </div>

                    <!-- Wall Posts Rendered via PHP -->
                    <div class="wall-posts">
                        <?php foreach ($_SESSION['wall_posts'] as $post): ?>
                            <div class="wall-post">
                                <img src="<?= htmlspecialchars($post['img']); ?>" class="wall-avatar" alt="Avatar" />
                                <div class="wall-body">
                                    <div class="wall-author"><?= htmlspecialchars($post['author']); ?></div>
                                    <div class="wall-meta"><?= htmlspecialchars($post['time']); ?></div>
                                    <div class="wall-content"><?= nl2br(htmlspecialchars($post['text'])); ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- LEFT SIDEBAR -->
        <div id="sidebar-left">
            <div class="box">
                <div class="box-header">Picture</div>
                <div class="box-body" style="text-align: center;">
                    <img class="profile-pic" src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=200&h=240&fit=crop" alt="Mark Zuckerberg" />
                    <span style="color: #008000; font-weight: bold; font-size: 10px;">● Online Now</span>
                </div>
            </div>

            <div class="box">
                <div class="box-header">Actions</div>
                <div class="box-body">
                    <ul class="action-list">
                        <li><a href="#wall">Post to Mark's Wall</a></li>
                        <li><a href="mailto:zuck@harvard.edu">Send Mark a Message</a></li>
                        <li>
                            <form method="post" style="display:inline; margin:0; padding:0;">
                                <input type="hidden" name="action" value="poke" />
                                <button type="submit" class="link-btn">Poke Mark! (<?= (int)$_SESSION['poke_count']; ?>)</button>
                            </form>
                        </li>
                        <li><a href="#">Add to Friends</a></li>
                        <li><a href="#">View Mark's Friends</a></li>
                        <li><a href="#">Forward to a Friend</a></li>
                    </ul>
                </div>
            </div>

            <div class="box">
                <div class="box-header">Connection</div>
                <div class="box-body" style="font-size: 10px; line-height: 1.4em;">
                    You are in the same network (<b>Harvard</b>). You have <b>4 mutual friends</b>.
                </div>
            </div>

            <div class="box">
                <div class="box-header">Contact Info</div>
                <div class="box-body">
                    <table class="info-table">
                        <tr><td class="label">Screenname:</td><td><?= htmlspecialchars($user['screenname']); ?></td></tr>
                        <tr><td class="label">Website:</td><td><a href="<?= htmlspecialchars($user['website']); ?>" target="_blank">thefacebook.com</a></td></tr>
                        <tr><td class="label">Room:</td><td><?= htmlspecialchars($user['residence']); ?></td></tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- RIGHT SIDEBAR -->
        <div id="sidebar-right">
            <!-- Mutual / Displayed Friends -->
            <div class="box">
                <div class="box-header">Friends (<?= count($friends); ?> in network)</div>
                <div class="box-body">
                    <div class="friends-grid">
                        <?php foreach ($friends as $friend): ?>
                            <div class="friend-card">
                                <img src="<?= htmlspecialchars($friend['img']); ?>" alt="<?= htmlspecialchars($friend['name']); ?>" />
                                <div class="name"><?= htmlspecialchars($friend['name']); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div style="text-align: center; margin-top: 8px;">
                        <a href="#">[ See all 48 friends ]</a>
                    </div>
                </div>
            </div>

            <!-- Groups Box -->
            <div class="box">
                <div class="box-header">Groups</div>
                <div class="box-body" style="font-size: 10px; line-height: 1.5em;">
                    • <a href="#">Kirkland House Council</a><br />
                    • <a href="#">Harvard Computer Society</a><br />
                    • <a href="#">Alpha Epsilon Pi (AEPi)</a><br />
                    • <a href="#">Syntax Error Anonymous</a>
                </div>
            </div>

            <!-- Vintage Campus Ad -->
            <div class="box">
                <div class="box-header">Campus Ad</div>
                <div class="box-body" style="background-color: #fafafa; font-size: 10px; text-align: center; padding: 10px 5px;">
                    <b>Harvard CS Hack Night</b><br />
                    Maxwell Dworkin Lab<br />
                    Friday at 9:00 PM.<br />
                    <span style="color: #666666;">Free pizza &amp; Bawls Guarana.</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Classic Footer -->
    <div id="footer">
        <a href="#">about</a> | 
        <a href="#">faq</a> | 
        <a href="#">terms</a> | 
        <a href="#">privacy</a> | 
        <a href="#">contact</a>
        <br /><br />
        a Mark Zuckerberg production<br />
        The Facebook &copy; 2004-2005
    </div>

</body>
</html>