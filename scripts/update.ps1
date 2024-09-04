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

info "Checking for installation"

if ( Not(Test-Path "$env:LOCALAPPDATA\Catalyst") ) {
    error "Catalyst is not installed"
    exit 0
}

info "Updating"

Remove-Item -Path "$env:LOCALAPPDATA\Catalyst" -Recurse

Invoke-WebRequest -Uri "https://github.com/tunafysh/Catalyst/releases/latest/download/catalyst.exe" -OutFile "$env:LOCALAPPDATA\Catalyst\catalyst-windows-$cpuarch.zip"

Expand-Archive -Path "$env:LOCALAPPDATA\Catalyst\catalyst-windows-$cpuarch.zip" -DestinationPath "$env:LOCALAPPDATA\Catalyst"
Remove-Item "$env:LOCALAPPDATA\Catalyst\catalyst-windows-$cpuarch.zip"

[Console]::ForegroundColor = "Green"
Write-Host "Catalyst updated successfully"
[Console]::ResetColor()

exit 0