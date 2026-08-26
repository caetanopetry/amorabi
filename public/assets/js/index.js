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
        let pointerId = null;
        let dragStartX = 0;
        let dragDeltaX = 0;
        let isDragging = false;
        let isCarouselVisible = true;
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
            slides.forEach((slide, i) => {
                slide.setAttribute("aria-hidden", String(i !== index));
            });
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
            if (prefersReducedMotion || slides.length < 2 || document.hidden || !isCarouselVisible || autoplayTimer) {
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

        const finishDrag = (event, cancelled = false) => {
            if (!isDragging || (pointerId !== null && event.pointerId !== pointerId)) return;

            const width = carousel.clientWidth || 1;
            const threshold = Math.min(80, width * 0.18);
            const shouldChange = !cancelled && Math.abs(dragDeltaX) >= threshold;

            track.classList.remove("is-dragging");
            carousel.classList.remove("is-dragging");

            if (pointerId !== null && carousel.hasPointerCapture(pointerId)) {
                carousel.releasePointerCapture(pointerId);
            }

            if (shouldChange) {
                goTo(index + (dragDeltaX < 0 ? 1 : -1), true);
            } else {
                update();
                restartAutoplay();
            }

            pointerId = null;
            dragDeltaX = 0;
            isDragging = false;
        };

        carousel.addEventListener("pointerdown", (event) => {
            if (slides.length < 2 || (event.pointerType === "mouse" && event.button !== 0) || event.target.closest("button, a")) return;

            pointerId = event.pointerId;
            dragStartX = event.clientX;
            dragDeltaX = 0;
            isDragging = true;
            stopAutoplay();
            carousel.setPointerCapture(pointerId);
            track.classList.add("is-dragging");
            carousel.classList.add("is-dragging");
        });

        carousel.addEventListener("pointermove", (event) => {
            if (!isDragging || event.pointerId !== pointerId) return;

            dragDeltaX = event.clientX - dragStartX;
            const width = carousel.clientWidth || 1;
            const resistance = (index === 0 && dragDeltaX > 0) || (index === slides.length - 1 && dragDeltaX < 0) ? 0.35 : 1;
            const offset = (-index * width) + (dragDeltaX * resistance);
            track.style.transform = `translateX(${offset}px)`;
        });

        carousel.addEventListener("pointerup", (event) => finishDrag(event));
        carousel.addEventListener("pointercancel", (event) => finishDrag(event, true));

        carousel.addEventListener("keydown", (event) => {
            if (event.key !== "ArrowLeft" && event.key !== "ArrowRight") return;
            event.preventDefault();
            goTo(index + (event.key === "ArrowRight" ? 1 : -1), true);
        });

        carousel.addEventListener("mouseenter", stopAutoplay);
        carousel.addEventListener("mouseleave", startAutoplay);
        carousel.addEventListener("focusin", stopAutoplay);
        carousel.addEventListener("focusout", startAutoplay);

        document.addEventListener("visibilitychange", () => {
            if (document.hidden) stopAutoplay();
            else startAutoplay();
        });

        if ("IntersectionObserver" in window) {
            const visibilityObserver = new IntersectionObserver(([entry]) => {
                isCarouselVisible = entry.isIntersecting && entry.intersectionRatio >= 0.25;
                if (isCarouselVisible) startAutoplay();
                else stopAutoplay();
            }, { threshold: [0, 0.25] });
            visibilityObserver.observe(carousel);
        }

        update();
        startAutoplay();
    });
});
