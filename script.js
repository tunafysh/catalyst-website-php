let url = window.location.href
let cmdString = `bash <(curl -s ${url})`;

const getOS = () => {2
    const userAgent = navigator.userAgent;
    const windowsPlatforms = ["Win32", "Win64", "Windows", "WinCE"];
    let os = "Unix";

    if (windowsPlatforms.some((platform) => userAgent.includes(platform))) {
        os = "Windows";
    }

    return os;
};

if ( getOS() == "Windows"){
    cmdString = `irm ${url} | iex`
}

let copied = false
const distributor = document.getElementById("distributor")

distributor.innerText = cmdString
distributor.addEventListener("click", (e) => {
    navigator.clipboard.writeText(cmdString)
    copied = true
    distributor.style.boxShadow = "0px 0px 10px 7px #10B981CC"
    distributor.style.color = "#10B981CC"
    distributor.innerText = "Copied to clipboard!"
})
