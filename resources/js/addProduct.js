const countrySelect = document.getElementById("countrySelect");
const regionSelect = document.getElementById("regionSelect");

if (countrySelect && regionSelect) {

    countrySelect.addEventListener("change", function () {
        const countryId = this.value;

        // Remove options
        while (regionSelect.firstChild) {
            regionSelect.removeChild(regionSelect.firstChild);
        }

        regionSelect.appendChild(new Option("-- Select country first --", ""));
        regionSelect.disabled = true;

        if (!countryId) return;

        fetch(`/regions-by-country/${countryId}`)
            .then((response) => response.json())
            .then((regions) => {

                while (regionSelect.firstChild) {
                    regionSelect.removeChild(regionSelect.firstChild);
                }

                regionSelect.appendChild(new Option("-- Select region --", ""));

                regions.forEach((region) => {
                    const opt = new Option(region.region, region.id);
                    regionSelect.appendChild(opt);
                });

                regionSelect.disabled = false;
            });
    });

}