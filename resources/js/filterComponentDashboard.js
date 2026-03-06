export default function filterComponentDashboard(initialFilters = {}) {
    return {
        filters: {
            roast: initialFilters.roast || "",
            type: initialFilters.type || "",
            country: initialFilters.country || "",
            in_stock: initialFilters.in_stock ?? "1",
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
                in_stock: "1",
            };
            window.location.href = "/dashboard";
        },
    };
}
