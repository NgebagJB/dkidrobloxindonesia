
document.addEventListener("DOMContentLoaded", () => {
    const observerOptions = {
        root: null,
        rootMargin: '0px 0px -80px 0px',
        threshold: 0.15
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    const revealElements = document.querySelectorAll('.reveal');
    revealElements.forEach(el => observer.observe(el));
});

document.addEventListener('DOMContentLoaded', function () {
    function initCarousel(wrapperId, trackId) {
        const wrapper = document.getElementById(wrapperId);
        const track = document.getElementById(trackId);
        if (!wrapper || !track) return;

        const leftBtn = wrapper.querySelector('[class$="-arrow-left"]');
        const rightBtn = wrapper.querySelector('[class$="-arrow-right"]');

        function checkOverflow() {
            const isOverflowing = track.scrollWidth > track.clientWidth + 2;
            wrapper.classList.toggle('is-scrollable', isOverflowing);
        }

        function scrollAmount() {
            const slide = track.querySelector(':scope > *');
            if (!slide) return 340;
            return slide.getBoundingClientRect().width + 24;
        }

        leftBtn.addEventListener('click', () => {
            track.scrollBy({ left: -scrollAmount(), behavior: 'smooth' });
        });
        rightBtn.addEventListener('click', () => {
            track.scrollBy({ left: scrollAmount(), behavior: 'smooth' });
        });

        checkOverflow();
        window.addEventListener('resize', checkOverflow);
        window.addEventListener('load', checkOverflow);
    }

    initCarousel('projectWrapper', 'projectTrack');
    initCarousel('gamepassWrapper', 'gamepassTrack');
});