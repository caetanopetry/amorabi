(() => {
    let storedTheme = null;
    const prefersDark = window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches;

    try {
        storedTheme = localStorage.getItem("amorabi-theme");
    } catch (error) {
        storedTheme = null;
    }

    const initialTheme = storedTheme || (prefersDark ? "dark" : "light");

    document.documentElement.dataset.theme = initialTheme;
})();

document.addEventListener("DOMContentLoaded", () => {
    const themeToggle = document.querySelector("[data-theme-toggle]");

    const setTheme = (theme) => {
        const isDark = theme === "dark";

        document.documentElement.dataset.theme = theme;
        document.body.classList.toggle("theme-dark", isDark);
        document.body.classList.toggle("theme-light", !isDark);

        try {
            localStorage.setItem("amorabi-theme", theme);
        } catch (error) {
            // Preferencia visual aplicada mesmo quando o armazenamento local estiver bloqueado.
        }

        if (themeToggle) {
            themeToggle.setAttribute("aria-pressed", String(isDark));
            themeToggle.setAttribute("aria-label", isDark ? "Ativar modo claro" : "Ativar modo escuro");
            themeToggle.title = isDark ? "Ativar modo claro" : "Ativar modo escuro";
        }

    };

    setTheme(document.documentElement.dataset.theme || "light");

    if (themeToggle) {
        themeToggle.addEventListener("click", () => {
            const currentTheme = document.documentElement.dataset.theme === "dark" ? "dark" : "light";
            setTheme(currentTheme === "dark" ? "light" : "dark");
        });
    }

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
        const setMenuOpen = (isOpen) => {
            nav.classList.toggle("open", isOpen);
            toggle.classList.toggle("open", isOpen);
            toggle.setAttribute("aria-expanded", String(isOpen));
            document.body.classList.toggle("menu-open", isOpen);
        };

        toggle.addEventListener("click", () => {
            setMenuOpen(!nav.classList.contains("open"));
        });

        nav.querySelectorAll("a").forEach((link) => {
            link.addEventListener("click", () => {
                setMenuOpen(false);
            });
        });

        document.addEventListener("click", (event) => {
            const clickedInsideMenu = nav.contains(event.target);
            const clickedToggle = toggle.contains(event.target);

            if (!clickedInsideMenu && !clickedToggle) {
                setMenuOpen(false);
            }
        });

        document.addEventListener("keydown", (event) => {
            if (event.key === "Escape") {
                setMenuOpen(false);
            }
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

    const pixDonation = document.querySelector("[data-pix-donation]");
    if (pixDonation) {
        const endpoint = pixDonation.dataset.endpoint;
        const valueButtons = pixDonation.querySelectorAll("[data-amount]");
        const customAmount = pixDonation.querySelector("[data-pix-amount]");
        const generateButton = pixDonation.querySelector("[data-pix-generate]");
        const feedback = pixDonation.querySelector("[data-pix-feedback]");
        const result = pixDonation.querySelector("[data-pix-result]");
        const qrImage = pixDonation.querySelector("[data-pix-qr]");
        const payloadField = pixDonation.querySelector("[data-pix-payload]");
        const amountLabel = pixDonation.querySelector("[data-pix-amount-label]");
        const copyButton = pixDonation.querySelector("[data-pix-copy]");
        const whatsappLink = pixDonation.querySelector("[data-pix-whatsapp]");

        let selectedAmount = "10";

        const setFeedback = (message, isError = false) => {
            if (!feedback) return;
            feedback.textContent = message;
            feedback.classList.toggle("error", isError);
            feedback.classList.toggle("success", !isError && message.length > 0);
        };

        const setLoading = (isLoading) => {
            if (!generateButton) return;
            generateButton.disabled = isLoading;
            generateButton.textContent = isLoading ? "Gerando..." : "Gerar QR Code Pix";
        };

        const normalizeAmount = (value) => {
            const normalized = String(value || "").replace("R$", "").replace(/\s/g, "").replace(",", ".");
            const amount = Number(normalized);
            return Number.isFinite(amount) ? amount.toFixed(2) : "";
        };

        valueButtons.forEach((button) => {
            button.addEventListener("click", () => {
                selectedAmount = button.dataset.amount || "";
                valueButtons.forEach((item) => item.classList.remove("active"));
                button.classList.add("active");

                if (customAmount) {
                    customAmount.value = "";
                }

                setFeedback("");
            });
        });

        if (customAmount) {
            customAmount.addEventListener("input", () => {
                selectedAmount = customAmount.value;
                valueButtons.forEach((button) => button.classList.remove("active"));
                setFeedback("");
            });
        }

        if (generateButton && endpoint) {
            generateButton.addEventListener("click", async () => {
                const amount = normalizeAmount(customAmount && customAmount.value ? customAmount.value : selectedAmount);

                if (!amount) {
                    setFeedback("Informe um valor para gerar o Pix.", true);
                    return;
                }

                setLoading(true);
                setFeedback("Gerando Pix...");

                try {
                    const response = await fetch(endpoint, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
                            "Accept": "application/json",
                        },
                        body: new URLSearchParams({ amount }),
                    });

                    const data = await response.json();

                    if (!response.ok || !data.ok) {
                        throw new Error(data.message || "Nao foi possivel gerar o Pix.");
                    }

                    if (qrImage) {
                        qrImage.src = data.qr_image_url;
                    }

                    if (payloadField) {
                        payloadField.value = data.payload;
                    }

                    if (amountLabel) {
                        amountLabel.textContent = `Pix copia e cola - ${data.amount_label}`;
                    }

                    if (whatsappLink && data.whatsapp_url) {
                        whatsappLink.href = data.whatsapp_url;
                    }

                    if (result) {
                        result.hidden = false;
                    }

                    if (payloadField && payloadField.value) {
                        payloadField.scrollIntoView({ behavior: "smooth", block: "center" });
                    }

                    setFeedback("Pix gerado. Depois do pagamento, envie o comprovante pelo WhatsApp.", false);
                } catch (error) {
                    if (result) {
                        result.hidden = true;
                    }
                    setFeedback(error.message || "Nao foi possivel gerar o Pix agora.", true);
                } finally {
                    setLoading(false);
                }
            });
        }

        if (copyButton && payloadField) {
            copyButton.addEventListener("click", async () => {
                try {
                    if (navigator.clipboard && navigator.clipboard.writeText) {
                        await navigator.clipboard.writeText(payloadField.value);
                    } else {
                        payloadField.focus();
                        payloadField.select();
                        document.execCommand("copy");
                    }
                    setFeedback("Codigo Pix copiado.", false);
                } catch (error) {
                    payloadField.focus();
                    payloadField.select();
                    document.execCommand("copy");
                    setFeedback("Codigo Pix copiado.", false);
                }
            });
        }
    }
});
