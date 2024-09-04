function info( $message ) {
    [Console]::ForegroundColor = "White"
    Write-Host "info: " -NoNewline
    [Console]::ResetColor()
    Write-Host $message
}

function warn( $message ) {
    [Console]::ForegroundColor = "Yellow"
    Write-Host "warn: " -NoNewline
    [Console]::ResetColor()
    Write-Host $message
}

function error( $message ) {
    [Console]::ForegroundColor = "Red"
    Write-Host "error: " -NoNewline
    [Console]::ResetColor()
    Write-Host $message
}

info "Initializing installation"

if ( Test-Path "$env:LOCALAPPDATA\Catalyst" ) {
    do {
        $inp = Read-Host "Catalyst already installed. Reainstall it? [y/n]"
        if ($inp -eq "y") {
            warn "Reainstalling..."
            Remove-Item -Path "$env:LOCALAPPDATA\Catalyst" -Recurse
        }
        elseif ($inp -eq "n") {
            warn "Exiting..."
            exit 0
        }
    } while ($inp.Length -ne 1)
}

$cpuarch = (Get-CimInstance Win32_OperatingSystem).OSArchitecture
switch ($cpuarch) {
    "32-bit" { $cpuarch = "x86" }
    "64-bit" { $cpuarch = "x64" }
    "ARM" { $cpuarch = "arm" }
    default {
        error "Unsupported CPU architecture: $cpuarch"
        exit 1
    }
}

info "Downloading binary"

Invoke-WebRequest -Uri "https://github.com/tunafysh/Catalyst/releases/latest/download/catalyst.exe" -OutFile "$env:LOCALAPPDATA\Catalyst\catalyst-windows-$cpuarch.zip"

info "Extracting binary"

Expand-Archive -Path "$env:LOCALAPPDATA\Catalyst\catalyst-windows-$cpuarch.zip" -DestinationPath "$env:LOCALAPPDATA\Catalyst"
Remove-Item "$env:LOCALAPPDATA\Catalyst\catalyst-windows-$cpuarch.zip"

info "Setting up Catalyst"

$previousPath = [Environment]::GetEnvironmentVariable("Path", "Machine")
[Environment]::SetEnvironmentVariable("Path", "$env:LOCALAPPDATA\Catalyst\;$previousPath", "Machine")

New-PSDrive -Name HKCR -PSProvider Registry -Root HKEY_CLASSES_ROOT

New-Item -Path "HKCR:\cly" -Force
Set-ItemProperty -Path "HKCR:\cly" -Name "(Default)" -Value "URL:cly Protocol"
Set-ItemProperty -Path "HKCR:\cly" -Name "URL Protocol" -Value ""

New-Item -Path "HKCR:\cly\shell" -Force
New-Item -Path "HKCR:\cly\shell\open" -Force
New-Item -Path "HKCR:\cly\shell\open\command" -Force
Set-ItemProperty -Path "HKCR:\cly\shell\open\command" -Name "(Default)" -Value "`"C:\Users\%USERNAME%\AppData\Local\Catalyst\clyhandler.exe`" `"%1`""

[Console]::ForegroundColor = "Green"
Write-Host "Catalyst installed successfully"
[Console]::ResetColor()

exit 0