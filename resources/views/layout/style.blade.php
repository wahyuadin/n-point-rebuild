@toastifyCss
<script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    sans: ["Inter", "sans-serif"]
                }
                , colors: {
                    brand: {
                        dark: "#0f172a"
                        , primary: "#10b981", // Emerald
                        secondary: "#3b82f6", // Blue
                    }
                , }
            , }
        , }
    , };

</script>
<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .custom-scroll::-webkit-scrollbar {
        height: 6px;
        width: 6px;
    }

    .custom-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .custom-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    .custom-scroll::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Animasi Fade In */
    .fade-in {
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

</style>

@stack('style')
