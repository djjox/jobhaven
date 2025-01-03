gsap.from(".navbar", {
    duration: 1,
    y: -50,
    opacity: 0,
    ease: "power3.out"
});

gsap.from(".hero-section h1", {
    duration: 1.2,
    y: 30,
    opacity: 0,
    ease: "power3.out",
    delay: 0.3
});

gsap.from(".hero-section p", {
    duration: 1,
    y: 30,
    opacity: 0,
    ease: "power3.out",
    delay: 0.6
});

gsap.from(".search-bar", {
    duration: 1,
    scale: 0.9,
    opacity: 0,
    ease: "power3.out",
    delay: 0.8
});

gsap.from(".btn", {
    duration: 0.8,
    opacity: 0,
    y: 20,
    ease: "power3.out",
    stagger: 0.2
});

gsap.from(".rating-badge", {
    duration: 1,
    scale: 0,
    ease: "elastic.out(1, 0.5)",
    delay: 1
});