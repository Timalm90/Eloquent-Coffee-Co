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

        updateFilters() {
            const params = new URLSearchParams(this.filters);
            window.location.href = `/dashboard?${params.toString()}`;
        },

        clearFilters() {
            this.filters = {
                roast: "",
                type: "",
                country: "",
                region: "",
            };
            window.location.href = "/dashboard";
        },
    };
}