async function fetchSonarrStats() {
    try {
        const response = await fetch('/plugins/sonarr-widget/api/stats.php');
        
        // Handle non-OK HTTP responses
        if (!response.ok) throw new Error('Network error');
        
        const data = await response.json();

        [span_4](start_span)// Check for the offline status flag defined in the spec[span_4](end_span)
        if (data.status === "offline") {
            displayOffline();
            return;
        }

        [span_5](start_span)// Update values in the DOM[span_5](end_span)
        document.getElementById("sonarr-series").innerText = data.series;
        document.getElementById("sonarr-episodes").innerText = data.episodes;
        document.getElementById("sonarr-downloading").innerText = data.downloading;
        document.getElementById("sonarr-queue").innerText = data.queue;

        [span_6](start_span)// Visual indicator for "Missing Episodes"[span_6](end_span)
        const missingEl = document.getElementById("sonarr-missing");
        missingEl.innerText = data.missing;
        
        if (data.missing > 0) {
            missingEl.classList.add("warning"); // Turns text red via our CSS
        } else {
            missingEl.classList.remove("warning");
        }

    } catch (error) {
        displayOffline();
    }
}

function displayOffline() {
    [span_7](start_span)[span_8](start_span)// Graceful handling when Sonarr is unreachable[span_7](end_span)[span_8](end_span)
    const elements = ["series", "episodes", "missing", "downloading", "queue"];
    elements.forEach(id => {
        const el = document.getElementById(`sonarr-${id}`);
        el.innerText = "Offline";
        el.classList.add("warning");
    });
}

[span_9](start_span)[span_10](start_span)[span_11](start_span)// Initial fetch and periodic refresh (default 60s)[span_9](end_span)[span_10](end_span)[span_11](end_span)
fetchSonarrStats();
setInterval(fetchSonarrStats, 60000);
