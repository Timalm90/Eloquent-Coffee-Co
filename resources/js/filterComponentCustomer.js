export default function filterComponentCustomer(initialFilters = {}) {
    return {
        filters: {
            search: initialFilters.search || "",
            roast: initialFilters.roast || "",
            type: initialFilters.type || "",
            country: initialFilters.country || "",
            in_stock: initialFilters.in_stock ?? "1",
        },

        get hasFilters() {
            return (
                this.filters.search ||
                this.filters.roast ||
                this.filters.type ||
                this.filters.country ||
                this.filters.in_stock !== "1"
            );
        },

        updateFilters() {
            const params = new URLSearchParams(this.filters);
            window.location.href = `/?${params.toString()}`;
        },

        clearFilters() {
            this.filters = {
                search: "",
                roast: "",
                type: "",
                country: "",
                in_stock: "1",
            };
            window.location.href = "/";
        },
    };
}