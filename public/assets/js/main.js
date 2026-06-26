document.addEventListener("DOMContentLoaded", () => {
    const header = document.querySelector("[data-header]");
    const toggle = document.querySelector("[data-menu-toggle]");
    const nav = document.querySelector("[data-nav]");

    const setHeaderState = () => {
        if (!header) return;
        header.classList.toggle("scrolled", window.scrollY > 12);
    };

    setHeaderState();
    window.addEventListener("scroll", setHeaderState, { passive: true });

    if (toggle && nav) {
        toggle.addEventListener("click", () => {
            const isOpen = nav.classList.toggle("open");
            toggle.classList.toggle("open", isOpen);
            toggle.setAttribute("aria-expanded", String(isOpen));
        });

        nav.querySelectorAll("a").forEach((link) => {
            link.addEventListener("click", () => {
                nav.classList.remove("open");
                toggle.classList.remove("open");
                toggle.setAttribute("aria-expanded", "false");
            });
        });
    }

    document.querySelectorAll('a[href^="#"], a[href*=".php#"]').forEach((link) => {
        link.addEventListener("click", (event) => {
            const href = link.getAttribute("href");
            const hash = href.includes("#") ? href.slice(href.indexOf("#")) : href;
            const target = document.querySelector(hash);

            if (target && (href.startsWith("#") || href.startsWith(window.location.pathname.split("/").pop()))) {
                event.preventDefault();
                target.scrollIntoView({ behavior: "smooth", block: "start" });
            }
        });
    });

    const revealItems = document.querySelectorAll(".reveal");
    if ("IntersectionObserver" in window) {
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("visible");
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.14 });

        revealItems.forEach((item) => revealObserver.observe(item));
    } else {
        revealItems.forEach((item) => item.classList.add("visible"));
    }

    const counters = document.querySelectorAll("[data-counter]");
    const animateCounter = (counter) => {
        const target = Number(counter.dataset.counter);
        const duration = 1100;
        const startTime = performance.now();

        const tick = (now) => {
            const progress = Math.min((now - startTime) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            counter.textContent = Math.round(target * eased).toLocaleString("pt-BR");

            if (progress < 1) {
                requestAnimationFrame(tick);
            } else {
                counter.textContent = target.toLocaleString("pt-BR");
                if (target === 40) {
                    counter.textContent = "+40";
                }
            }
        };

        requestAnimationFrame(tick);
    };

    if ("IntersectionObserver" in window) {
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.4 });

        counters.forEach((counter) => counterObserver.observe(counter));
    } else {
        counters.forEach(animateCounter);
    }

    const form = document.querySelector("[data-contact-form]");
    if (form) {
        const feedback = form.querySelector("[data-form-feedback]");
        const requiredFields = form.querySelectorAll("[required]");

        requiredFields.forEach((field) => {
            field.addEventListener("input", () => {
                field.classList.remove("field-error");
                if (feedback) {
                    feedback.textContent = "";
                    feedback.classList.remove("error");
                }
            });
        });

        form.addEventListener("submit", (event) => {
            let valid = true;

            requiredFields.forEach((field) => {
                const isEmail = field.type === "email";
                const hasValue = field.value.trim().length > 0;
                const emailOk = !isEmail || /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(field.value.trim());

                if (!hasValue || !emailOk) {
                    valid = false;
                    field.classList.add("field-error");
                }
            });

            if (!valid) {
                event.preventDefault();
                if (feedback) {
                    feedback.textContent = "Confira os campos obrigatórios antes de enviar.";
                    feedback.classList.add("error");
                }
            }
        });
    }
});
