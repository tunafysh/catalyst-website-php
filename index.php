<?php
    //Initializing variables/objects
    $latestversion = 0.62;
    $updateagentpattern = '/Catalyst\/(Windows|Unix)\/\d.\d{2}\/(check|update)/';
    $useragent = $_SERVER['HTTP_USER_AGENT'];
    $psinstaller = fopen("scripts/install.ps1", "r") or die("PHP is fucked up man");
    $shinstaller = fopen("scripts/install", "r") or die("PHP is still fucked up");
    $psbetainstaller = fopen("scripts/betainstall.ps1", "r") or die("PHP is fucked up man");
    $shbetainstaller = fopen("scripts/betainstall", "r") or die("PHP is still fucked up");
    $psudpater = fopen("scripts/update.ps1", "r") or die("PHP is fucked up man");
    $shudpater = fopen("scripts/update", "r") or die("PHP is fucked up man");

    class Catalyst {
        public $os
        public $ver
        public $action
        function parse($string) {
            $data = explode("/", $string);
            $data = array_shift($data)
            $this->os = $data[0]
            $this->ver = $data[1]
            $this->action = $data[2]
        }

        function checkupd() {
            $ver = $this->ver
            $os = $this->os
            switch ($ver){
                case $ver > $latestversion:
                    header('Content-Type: text/plain');
                    echo "Largerversion";
                    exit();
                    break;

                case $ver == $latestversion:
                    header('Content-Type: text/plain');
                    echo "Equalversion";
                    exit();
                    break;
                default: 
                    header('Content-Type: text/plain');
                    echo "Latestversion";
                    exit();
                    break;
            }
        }

        function update() {
            $ver = $this->ver
            $os = $this->os
            switch ($ver){
                case $ver > $latestversion:
                    header('Content-Type: text/plain');
                    echo "Largerversion";
                    exit();
                    break;

                case $ver == $latestversion:
                    header('Content-Type: text/plain');
                    echo "Equalversion";
                    exit();
                    break;
                default: 
                    header('Content-Type: text/plain');
                    if(str_contains($os, "Win")){
                        echo fread($psudpater, filesize("scripts/update.ps1"));
                    }
                    else{
                        echo fread($psudpater, filesize("scripts/update"));
                    }
                    exit();
                    break;
            }
        }
    }

    
    if(str_contains($useragent, "PowerShell")){
        if (str_contains($useragent, "Win")){
            header('Content-Type: text/plain');
            echo fread($psinstaller, filesize("scripts/install.ps1"));
            fclose($psinstaller);
            exit();
        }
    }
    else if (str_contains($useragent, "curl")){
         if (str_contains($useragent, "Linux")){
            header('Content-Type: text/plain');
            echo fread($shinstaller, filesize("scripts/install"));
            fclose($shinstaller);
            exit();
        }
    }
    else {
        preg_match_all($useragent, $updateagentpattern, $matches)
        if (!$matches > 0){
            exit()
        }

        $data = new Catalyst()

        if($data->action == "check"){
            $data->checkupd()
        }
        else{
            $data->update()
        }

            
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A build system made in rust that is scriptable with Lua.">
        <title>Catalyst</title>
        <link rel="stylesheet" href="style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    </head>
    <body>
        <div id="main">
            <div id="navbar">
                <h1 id="navtitle">Catalyst</h1>
                <ul id="links">
                    <a style="text-decoration: none;" href="https://github.com/tunafysh/Catalyst/wiki"><li class="link">Docs</li></a>
                    <a style="text-decoration: none;" href="https://github.com/tunafysh/Catalyst/"><li class="link">Source</li></a>
                </ul>
            </div>
            <main id="content">
                <h1 id="header">Build systems <br> <span id="coloredtitle">Made Easy</span></h1>
                <p id="description">A build system, inspired by make, made in rust and that is scriptable with Lua</p>
                <div id="distributor"></div>
            </main>
        </div>
        <script src="script.js"></script>
    </body>
    </html> 