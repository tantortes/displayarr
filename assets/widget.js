async function fetchSonarrStats() {

    try {

        const response = await fetch('/plugins/sonarr-widget/api/stats.php');
        const data = await response.json();

        if (data.status === "offline") {
            return;
        }

        document.getElementById("sonarr-series").innerText = data.series;
        document.getElementById("sonarr-episodes").innerText = data.episodes;
        document.getElementById("sonarr-missing").innerText = data.missing;
        document.getElementById("sonarr-downloading").innerText = data.downloading;
        document.getElementById("sonarr-queue").innerText = data.queue;

    } catch(e) {
        console.log("Sonarr widget error", e);
    }

}

setInterval(fetchSonarrStats, 60000);
fetchSonarrStats();
