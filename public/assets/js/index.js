document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("[data-carousel]").forEach((carousel) => {
        const track = carousel.querySelector("[data-carousel-track]");
        const slides = Array.from(carousel.querySelectorAll(".carousel-slide"));
        const prevBtn = carousel.querySelector("[data-carousel-prev]");
        const nextBtn = carousel.querySelector("[data-carousel-next]");
        const dotsWrap = carousel.querySelector("[data-carousel-dots]");

        if (!track || slides.length === 0) {
            return;
        }

        let index = 0;
        let autoplayTimer = null;
        const prefersReducedMotion = window.matchMedia && window.matchMedia("(prefers-reduced-motion: reduce)").matches;

        const dots = slides.map((_, i) => {
            if (!dotsWrap) return null;
            const dot = document.createElement("button");
            dot.type = "button";
            dot.setAttribute("aria-label", `Ir para o slide ${i + 1}`);
            dot.addEventListener("click", () => goTo(i, true));
            dotsWrap.appendChild(dot);
            return dot;
        }).filter(Boolean);

        const update = () => {
            track.style.transform = `translateX(-${index * 100}%)`;
            dots.forEach((dot, i) => {
                const isActive = i === index;
                dot.classList.toggle("active", isActive);
                dot.setAttribute("aria-current", isActive ? "true" : "false");
            });
        };

        const goTo = (newIndex, userTriggered) => {
            index = (newIndex + slides.length) % slides.length;
            update();
            if (userTriggered) {
                restartAutoplay();
            }
        };

        const next = () => goTo(index + 1, false);

        const startAutoplay = () => {
            if (prefersReducedMotion || slides.length < 2) {
                return;
            }
            autoplayTimer = window.setInterval(next, 5000);
        };

        const stopAutoplay = () => {
            if (autoplayTimer) {
                window.clearInterval(autoplayTimer);
                autoplayTimer = null;
            }
        };

        const restartAutoplay = () => {
            stopAutoplay();
            startAutoplay();
        };

        if (prevBtn) {
            prevBtn.addEventListener("click", () => goTo(index - 1, true));
        }

        if (nextBtn) {
            nextBtn.addEventListener("click", () => goTo(index + 1, true));
        }

        carousel.addEventListener("mouseenter", stopAutoplay);
        carousel.addEventListener("mouseleave", startAutoplay);
        carousel.addEventListener("focusin", stopAutoplay);
        carousel.addEventListener("focusout", startAutoplay);

        update();
        startAutoplay();
    });
});
