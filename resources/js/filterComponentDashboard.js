export default function filterComponentDashboard(initialFilters = {}) {
    return {
        filters: {
            roast: initialFilters.roast || "",
            type: initialFilters.type || "",
            country: initialFilters.country || "",
        },
        
get hasFilters() {
    return (
        this.filters.roast ||
        this.filters.type ||
        this.filters.country
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
            };
            window.location.href = "/dashboard";
        },
    };
}
