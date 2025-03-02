import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

document.addEventListener('DOMContentLoaded', () => {
    // Only run animation on welcome, login, and register pages
    const allowedPaths = ['/', '/login', '/register'];
    if (!allowedPaths.includes(document.location.pathname)) return;
    // Create container for bars
    const barsContainer = document.createElement('div');
    barsContainer.style.position = 'fixed';
    barsContainer.style.inset = '0';
    barsContainer.style.display = 'flex';
    barsContainer.style.justifyContent = 'space-between';
    barsContainer.style.zIndex = '9999';
    document.body.appendChild(barsContainer);

    // Create 8 vertical bars
    const bars = [];
    for (let i = 0; i < 8; i++) {
        const bar = document.createElement('div');
        bar.style.width = '15%';
        bar.style.height = '100%';
        // if(document.location.pathname === "/login")
        bar.style.background = (document.location.pathname === "/login" || document.location.pathname === "/register") ? '#076abd' : 'white';
        bar.style.transformOrigin = i % 2 === 0 ? 'top' : 'bottom';
        barsContainer.appendChild(bar);
        bars.push(bar);
    }

    // Main timeline
    const mainTimeline = gsap.timeline({ defaults: { ease: 'power3.out' } });

    // Bars animation
    mainTimeline
        .to(bars, {
            scaleY: 0.2,
            duration: 0.8,
            stagger: {
                each: 0.1,
                from: 'edges',
                yoyo: true,
                repeat: 2
            },
            ease: 'power2.inOut'
        })
        .to(barsContainer, {
            opacity: 0,
            duration: 0.5,
            onComplete: () => barsContainer.remove()
        })
        .from('.glass-nav', {
            y: -100,
            opacity: 0,
            duration: 1,
            ease: 'elastic.out(1, 0.8)'
        })
        .from('.nav-item', {
            opacity: 0,
            y: -20,
            duration: 0.8,
            stagger: 0.2,
            ease: 'power2.out'
        })
        .from('.hero-text', {
            opacity: 0,
            x: -50,
            duration: 1,
            ease: 'power2.out'
        });

    // Logo animation
    gsap.to('.devconnect-logo', {
        scale: 1.05,
        duration: 1,
        ease: 'power2.inOut',
        yoyo: true,
        repeat: -1
    });

    
});