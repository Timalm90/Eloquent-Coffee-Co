export default function filterComponentDashboard(initialFilters = {}) {
    return {
        filters: {
            roast: initialFilters.roast || "",
            type: initialFilters.type || "",
            country: initialFilters.country || "",
            region: initialFilters.region || "",
        },

        get hasFilters() {
            return (
                this.filters.roast ||
                this.filters.type ||
                this.filters.country ||
                this.filters.region
            );
        },

        async updateFilters() {
            const params = new URLSearchParams(this.filters);
            const url = `/dashboard?${params.toString()}`;

            try {
                const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                if (!res.ok) throw new Error('Network response was not ok');
                const html = await res.text();

                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newTable = doc.getElementById('products-table');
                const currentTable = document.getElementById('products-table');

                if (newTable && currentTable) {
                    currentTable.replaceWith(newTable);
                }

                // Update URL without reloading
                history.pushState({}, '', url);
            } catch (err) {
                console.error('Failed to fetch filtered products', err);
                // Fallback to full reload
                window.location.href = url;
            }
        },

        clearFilters() {
            this.filters = {
                roast: "",
                type: "",
                country: "",
                region: "",
            };

            // fetch and replace products
            this.updateFilters();
        },
    };
}