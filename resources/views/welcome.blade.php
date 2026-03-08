
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roman Graupner – Instalatér</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Sora:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --c-base: #01060F;
            --c-mid: #051224;
            --c-accent: #0A2D6E;
            --c-highlight: #1D8BF1;
            --c-frost: #D4ECFF;
            --c-surface: #FFFFFF;
            --c-subtle: #ECF3FB;
            --c-ink: #0D1A2E;
            --c-dim: #607D9E;
            --c-panel: rgba(255,255,255,0.04);
            --c-divider: rgba(255,255,255,0.08);

            --radius: 16px;
            --ease: 0.35s cubic-bezier(.4,0,.2,1);
            /* Legacy aliases for non-transformed sections */
            --deep: var(--c-base);
            --navy: var(--c-mid);
            --blue: var(--c-accent);
            --cyan: var(--c-highlight);
            --ice: var(--c-frost);
            --white: var(--c-surface);
            --off: var(--c-subtle);
            --text: var(--c-ink);
            --muted: var(--c-dim);
            --glass: var(--c-panel);
            --glass-border: var(--c-divider);
            --r: var(--radius);
            --tr: var(--ease);
        }

        html { scroll-behavior: smooth; }
        body { font-family: 'Space Grotesk', sans-serif; color: var(--text); line-height: 1.7; background: var(--white); overflow-x: hidden; }
        h1,h2,h3,h4 { font-family: 'Sora', sans-serif; }

        /* === AMBIENT ORBS === */
        [data-ambient] {
            position: absolute; border-radius: 50%; pointer-events: none; z-index: 0;
            filter: blur(80px); opacity: 0.4;
        }

        /* === NAV === */
        .nav-top {
            width: 100%; background: var(--deep); border-bottom: 1px solid rgba(255,255,255,0.04);
            position: fixed; top: 0; z-index: 201;
            transition: transform 0.35s ease, opacity 0.35s ease;
        }
        .nav-top.hidden { transform: translateY(-100%); opacity: 0; }
        .nav-top-inner {
            max-width: 1260px; margin: auto; padding: 6px 5%;
            display: flex; justify-content: space-between; align-items: center;
        }
        .nav-top-left {
            display: flex; align-items: center; gap: 20px; font-size: 0.75rem; color: rgba(255,255,255,0.4);
        }
        .nav-top-left i { margin-right: 5px; font-size: 0.7rem; }
        .nav-top-right {
            display: flex; align-items: center; gap: 12px;
        }
        .nav-top-right > a {
            color: rgba(255,255,255,0.3); font-size: 0.8rem; transition: var(--tr); text-decoration: none;
        }
        .nav-top-right > a:hover { color: var(--cyan); }
        .nav-phone-highlight {
            display: inline-flex; align-items: center; gap: 8px; text-decoration: none;
            font-weight: 700; font-size: 0.82rem; color: #fff; letter-spacing: 0.3px;
            transition: var(--tr);
        }
        .nav-phone-highlight:hover { color: var(--cyan); }
        .nav-phone-highlight .phone-icon {
            width: 22px; height: 22px; border-radius: 50%;
            background: var(--c-highlight);
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 0.55rem; color: #fff;
            animation: phoneRing 4s ease-in-out infinite;
        }
        @keyframes phoneRing {
            0%, 88%, 100% { transform: rotate(0); }
            90% { transform: rotate(14deg); }
            92% { transform: rotate(-12deg); }
            94% { transform: rotate(10deg); }
            96% { transform: rotate(-6deg); }
        }

        nav {
            position: fixed; top: 30px; width: 100%; z-index: 200;
            background: rgba(11,29,53,0.65); backdrop-filter: blur(24px) saturate(1.6);
            border-bottom: 1px solid rgba(255,255,255,0.06);
            transition: top 0.35s ease, background 0.35s ease, box-shadow 0.35s ease;
        }
        nav.scrolled {
            top: 0; background: rgba(11,29,53,0.88);
            box-shadow: 0 4px 24px rgba(0,0,0,0.2);
        }
        nav .wrap {
            display: flex; justify-content: space-between; align-items: center;
            padding: 14px 5%; max-width: 1260px; margin: auto;
        }
        nav .nav-left {
            display: flex; align-items: center; gap: 32px;
        }
        /* Logo */
        nav .logo {
            font-family: 'Sora', sans-serif; font-weight: 800; font-size: 1.25rem;
            color: #fff; letter-spacing: -0.5px; text-decoration: none;
            display: flex; align-items: center; gap: 0;
        }
        nav .logo .logo-first { color: rgba(255,255,255,0.45); font-weight: 400; font-size: 0.85rem; margin-right: 4px; }
        nav .logo .logo-last { color: #fff; }
        nav .logo .logo-drop {
            display: inline-block; margin-left: 2px; vertical-align: super;
            width: 5px; height: 5px; position: relative;
            margin-bottom: 20px;
            animation: dropFall 2s easecreat.5s ease-in-out infinite;
        }
        nav .logo .logo-drop svg { width: 100%; height: 100%; }
        @keyframes dropFall {
            0%, 100% { transform: translateY(0); opacity: 1; }
            40% { transform: translateY(0); opacity: 1; }
            60% { transform: translateY(6px); opacity: 0.6; }
            75% { transform: translateY(0px); opacity: 0; }
            90% { transform: translateY(0); opacity: 0; }
            95% { opacity: 1; }
        }

        /* Nav links */
        nav .nav-links { list-style: none; display: flex; gap: 6px; align-items: center; }
        nav .nav-links li a {
            text-decoration: none; color: rgba(255,255,255,0.5); font-size: 0.82rem; font-weight: 500;
            transition: var(--tr); padding: 6px 12px; border-radius: 8px; position: relative;
        }
        nav .nav-links li a:hover { color: #fff; background: rgba(255,255,255,0.06); }
        /* Active dot indicator instead of underline */
        nav .nav-links li a::after {
            content: ''; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%);
            width: 4px; height: 4px; border-radius: 50%; background: var(--cyan);
            opacity: 0; transition: var(--tr);
        }
        nav .nav-links li a:hover::after { opacity: 1; }

        nav .nav-right {
            display: flex; align-items: center; gap: 10px;
        }
        nav .nav-phone {
            display: flex; align-items: center; gap: 7px; text-decoration: none;
            color: rgba(255,255,255,0.7); font-weight: 600; font-size: 0.82rem; transition: var(--tr);
            padding: 7px 14px; border-radius: 32px;
            border: 1px solid rgba(255,255,255,0.08); background: rgba(255,255,255,0.03);
        }
        nav .nav-phone i { color: var(--cyan); font-size: 0.72rem; }
        nav .nav-phone:hover { border-color: rgba(34,211,238,0.25); background: rgba(255,255,255,0.07); color: #fff; }
        nav .nav-cta {
            background: #fff; color: var(--c-base) !important;
            padding: 8px 20px; border-radius: 32px; font-weight: 600; font-size: 0.82rem;
            text-decoration: none; transition: var(--tr); display: inline-flex; align-items: center; gap: 6px;
        }
        nav .nav-cta:hover { transform: translateY(-1px); box-shadow: 0 4px 20px rgba(255,255,255,0.15); }
        .hamburger { display: none; background: none; border: none; font-size: 1.3rem; color: #fff; cursor: pointer; }

        /* === LANDING BANNER === */
        [data-section="landing"] {
            min-height: 100vh; display: flex; align-items: center; position: relative; overflow: hidden;
            background: var(--c-base); padding: 160px 5% 100px;
        }
        [data-section="landing"] [data-ambient="primary"] {
            width: 600px; height: 600px; background: var(--c-accent);
            top: -15%; right: 0; opacity: 0.05;
            animation: ambientDrift 20s ease-in-out infinite alternate;
        }
        [data-section="landing"] [data-ambient="secondary"] {
            width: 400px; height: 400px; background: var(--c-highlight);
            bottom: -10%; left: -8%; opacity: 0.04;
            animation: ambientDrift 25s ease-in-out infinite alternate-reverse;
        }
        @keyframes ambientDrift {
            0% { transform: translate(0, 0); }
            100% { transform: translate(30px, -20px); }
        }

        /* Landing layout — centered column */
        [data-section="landing"] .container-inner {
            max-width: 860px; width: 100%; margin: auto;
            display: flex; flex-direction: column; align-items: center;
            text-align: center;
            position: relative; z-index: 1;
        }
        .pitch {
            display: flex; flex-direction: column; align-items: center;
            width: 100%;
        }

        /* Pitch — headline area */
        .pitch__heading {
            font-size: clamp(2rem, 6vw, 9.5rem); font-weight: 800; color: #fff;
            line-height: 0.88; letter-spacing: -0.04em; margin-bottom: 32px;
            text-transform: uppercase; text-align: center;
        }
        .pitch__heading .accent-text {
            color: var(--c-highlight);
            -webkit-text-fill-color: var(--c-highlight);
        }
        .pitch__tagline {
            color: rgba(255,255,255,0.5); font-size: 1.05rem; margin-bottom: 36px;
            max-width: 500px; font-weight: 400; line-height: 1.7; text-align: center;
        }

        /* Hero eyebrow */
        .hero-eyebrow {
            display: flex; align-items: center; gap: 20px; margin-bottom: 28px;
            font-size: 1.5rem; font-weight: 600; letter-spacing: 3.5px;
            text-transform: uppercase; color: rgba(255,255,255,0.32);
        }
        .hero-eyebrow__line {
            flex: 1; max-width: 52px; height: 1px;
            background: rgba(255,255,255,0.15);
        }
        .hero-eyebrow__line--right {
            background: rgba(255,255,255,0.15);
        }

        /* Trust badges row */
        .trust-badges {
            display: flex; gap: 10px; margin-bottom: 32px; flex-wrap: wrap; justify-content: center;
        }
        .trust-badge {
            display: flex; align-items: center; gap: 7px;
            font-size: 0.75rem; color: rgba(255,255,255,0.55); font-weight: 500;
            background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.09);
            padding: 6px 14px; border-radius: 50px;
            transition: var(--ease);
        }
        .trust-badge:hover { background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.15); }
        .trust-badge i {
            color: var(--c-highlight); font-size: 0.68rem;
        }

        /* Action links */
        .cta-group { display: flex; gap: 14px; flex-wrap: wrap; justify-content: center; }
        .action-link {
            display: inline-flex; align-items: center; gap: 8px; padding: 15px 32px; border-radius: 32px;
            font-weight: 600; font-size: 0.95rem; text-decoration: none; transition: var(--ease);
            border: none; cursor: pointer; font-family: inherit;
        }
        .action-link--primary {
            background: #fff; color: var(--c-base);
            box-shadow: 0 4px 20px rgba(255,255,255,0.1);
        }
        .action-link--primary:hover {
            background: rgba(255,255,255,0.9);
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 32px rgba(255,255,255,0.18);
        }
        .action-link--outline {
            background: rgba(255,255,255,0.05); color: rgba(255,255,255,0.8);
            border: 1px solid rgba(255,255,255,0.1);
            backdrop-filter: blur(8px);
        }
        .action-link--outline:hover {
            background: rgba(255,255,255,0.1); color: #fff;
            border-color: rgba(255,255,255,0.2);
        }

        /* === RAINFALL — subtle & slow === */
        .rain-field { position: absolute; inset: 0; pointer-events: none; z-index: 0; overflow: hidden; }
        .droplet {
            position: absolute; top: -30px; opacity: 0;
            animation: dropletDescend linear infinite;
        }
        .droplet { filter: blur(2px); }
        .droplet--far { filter: blur(5px); opacity: 0.5; }
        .drop-svg {
            display: block;
            filter: drop-shadow(0 0 3px rgba(34,211,238,0.3)) drop-shadow(0 1px 4px rgba(34,211,238,0.1));
        }
        .drop-svg path { fill: url(#dropFillGrad); }
        .drop-svg.drop-lg { width: 8px; height: 13px; }
        .drop-svg.drop-md { width: 6px; height: 10px; }
        .drop-svg.drop-sm { width: 4px; height: 7px; }
        .drop-svg.drop-xs { width: 3px; height: 5px; opacity: 0.25; }
        @keyframes dropletDescend {
            0% { transform: translateY(-30px); opacity: 0; }
            5% { opacity: 0.45; }
            80% { opacity: 0.3; }
            100% { transform: translateY(calc(100vh + 50px)); opacity: 0; }
        }
        .splash {
            position: absolute; pointer-events: none;
            width: 12px; height: 3px;
            border: 1px solid rgba(34,211,238,0.15);
            border-radius: 50%; opacity: 0;
            animation: splashExpand 5.2s ease-out infinite;
        }
        @keyframes splashExpand {
            0%, 75% { transform: scale(0); opacity: 0; }
            77% { transform: scale(1); opacity: 0.3; }
            90% { transform: scale(3); opacity: 0.08; }
            100% { transform: scale(6); opacity: 0; }
        }
        .rain-pool {
            position: absolute; bottom: 0; left: 0; right: 0; height: 100px;
            background: transparent;
            pointer-events: none;
        }

        /* Hero entrance animation */
        @keyframes heroSlideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .hero-anim-1 { animation: heroSlideUp 1s cubic-bezier(.22,.68,0,1.2) 0.1s both; }

        /* === TYPEWRITER === */
        .pitch__heading.tw-typing::after {
            content: '|';
            color: rgba(255,255,255,0.6);
            font-weight: 300;
            animation: twBlink 0.65s step-end infinite;
        }
        @keyframes twBlink {
            0%, 100% { opacity: 0.6; }
            50% { opacity: 0; }
        }

        /* === SECTION COMMONS === */
        section { padding: 110px 5%; position: relative; }
        .section-tag {
            display: inline-block; font-size: 0.75rem; font-weight: 600; letter-spacing: 2px; text-transform: uppercase;
            color: var(--blue); margin-bottom: 12px;
            background: rgba(59,130,246,0.08);
            padding: 6px 16px; border-radius: 50px;
        }
        .section-title { font-size: clamp(1.8rem,3vw,2.6rem); font-weight: 800; letter-spacing: -1px; color: var(--deep); margin-bottom: 14px; }
        .section-desc { color: var(--muted); max-width: 480px; font-size: 1rem; }

        /* === ABOUT (removed — merged into hero) === */

        /* === SERVICES === */
        .services .wrap { max-width: 1260px; margin: auto; }
        .services .header { margin-bottom: 48px; }
        .services-bento {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 16px;
        }
        .srv {
            background: var(--white); border: 1px solid rgba(11,29,53,0.06); border-radius: 20px;
            padding: 32px 28px; transition: var(--tr); position: relative; overflow: hidden;
            display: flex; flex-direction: column; justify-content: flex-end;
            min-height: 200px;
        }
        .srv:hover { transform: translateY(-5px); box-shadow: 0 16px 48px rgba(11,29,53,0.1); }

        /* Bento sizing */
        .srv-wide { grid-column: span 7; min-height: 240px; }
        .srv-narrow { grid-column: span 5; }
        .srv-third { grid-column: span 4; }
        .srv-emergency { grid-column: span 5; }
        .srv-medium { grid-column: span 7; }

        /* Large decorative icon — top-right corner */
        .srv .srv-deco {
            position: absolute; top: -8px; right: -8px;
            font-size: 6rem; color: rgba(59,130,246,0.05);
            transition: var(--tr); line-height: 1;
        }
        .srv:hover .srv-deco { color: rgba(59,130,246,0.09); transform: scale(1.08) rotate(-4deg); }

        /* Number label */
        .srv .srv-num {
            font-family: 'Sora', sans-serif; font-size: 0.65rem; font-weight: 800;
            color: var(--blue); letter-spacing: 1.5px; text-transform: uppercase;
            margin-bottom: 12px; opacity: 0.6;
        }
        .srv h3 { font-size: 1.1rem; font-weight: 700; color: var(--deep); margin-bottom: 6px; position: relative; }
        .srv p { color: var(--muted); font-size: 0.85rem; position: relative; line-height: 1.6; }

        /* Tag pills on cards */
        .srv .srv-tags { display: flex; gap: 6px; flex-wrap: wrap; margin-top: 14px; position: relative; }
        .srv .srv-tags span {
            padding: 4px 10px; border-radius: 50px; font-size: 0.68rem; font-weight: 600;
            background: rgba(59,130,246,0.06); color: var(--blue); letter-spacing: 0.3px;
        }

        /* Emergency card — special dark treatment */
        .srv-emergency {
            background: var(--deep); border-color: rgba(59,130,246,0.15);
        }
        .srv-emergency .srv-num { color: var(--cyan); }
        .srv-emergency h3 { color: #fff; }
        .srv-emergency p { color: rgba(255,255,255,0.45); }
        .srv-emergency .srv-deco { color: rgba(34,211,238,0.06); }
        .srv-emergency:hover .srv-deco { color: rgba(34,211,238,0.1); }
        .srv-emergency .srv-tags span {
            background: rgba(34,211,238,0.1); color: var(--cyan);
        }
        /* Pulsing live dot */
        .srv-emergency .pulse-dot {
            display: inline-block; width: 8px; height: 8px; border-radius: 50%;
            background: #22D3EE; margin-right: 6px; vertical-align: middle;
            animation: emergencyPulse 2s ease-in-out infinite;
            box-shadow: 0 0 8px rgba(34,211,238,0.5);
        }
        @keyframes emergencyPulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(0.8); }
        }

        /* === GALLERY === */
        .gallery {
            background: var(--deep); position: relative; overflow: hidden;
        }
        .gallery .wrap { max-width: 1260px; margin: auto; position: relative; z-index: 1; }
        .gallery .section-tag { background: rgba(255,255,255,0.06); color: var(--cyan); }
        .gallery .section-title { color: #fff; }
        .gallery .section-desc { color: rgba(255,255,255,0.45); }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: auto auto;
            gap: 16px;
            margin-top: 48px;
        }
        .gallery-item {
            position: relative; border-radius: 16px; overflow: hidden;
            aspect-ratio: 4/3; cursor: pointer;
            transition: var(--tr);
        }
        .gallery-item.tall { grid-row: span 2; aspect-ratio: auto; }
        .gallery-item:hover { transform: translateY(-4px); box-shadow: 0 16px 48px rgba(0,0,0,0.3); }
        .gallery-item .gallery-bg {
            position: absolute; inset: 0;
            display: flex; align-items: center; justify-content: center;
        }
        .gallery-item .gallery-bg i {
            font-size: 3rem; color: rgba(255,255,255,0.06);
            transition: var(--tr);
        }
        .gallery-item:hover .gallery-bg i { color: rgba(255,255,255,0.1); transform: scale(1.1); }
        .gallery-item .gallery-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(11,29,53,0.85) 0%, transparent 60%);
            display: flex; flex-direction: column; justify-content: flex-end;
            padding: 20px; opacity: 0; transition: opacity 0.3s ease;
        }
        .gallery-item:hover .gallery-overlay { opacity: 1; }
        .gallery-overlay h4 { color: #fff; font-size: 0.95rem; font-weight: 700; margin-bottom: 4px; }
        .gallery-overlay p { color: rgba(255,255,255,0.5); font-size: 0.78rem; }
        .gallery-overlay .gallery-tag {
            display: inline-block; padding: 3px 10px; border-radius: 50px; font-size: 0.65rem;
            font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase;
            background: rgba(59,130,246,0.2); color: var(--cyan);
            margin-bottom: 8px; width: fit-content;
        }

        /* === TESTIMONIALS === */
        .reviews { background: var(--off); }
        .reviews .wrap { max-width: 1260px; margin: auto; }
        .reviews .header { margin-bottom: 56px; }
        .reviews-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .rev {
            background: var(--white); border: 1px solid rgba(11,29,53,0.06); border-radius: 20px;
            padding: 32px 28px; transition: var(--tr); position: relative;
        }
        .rev:hover { box-shadow: 0 12px 40px rgba(11,29,53,0.08); transform: translateY(-3px); }
        .rev .stars { color: #F59E0B; font-size: 0.85rem; margin-bottom: 16px; }
        .rev blockquote { color: var(--muted); font-size: 0.92rem; font-style: italic; margin-bottom: 20px; }
        .rev .who { display: flex; align-items: center; gap: 12px; }
        .rev .who .init {
            width: 40px; height: 40px; border-radius: 50%;
            background: var(--c-highlight); color: #fff;
            display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem;
        }
        .rev .who .name { font-weight: 700; color: var(--deep); font-size: 0.88rem; }
        .rev .who .loc { font-size: 0.78rem; color: var(--muted); }

        /* === CONTACT === */
        .contact {
            background-color: var(--deep);
            border-top-left-radius: 50px;
            border-top-right-radius: 50px;
            padding-bottom: 40px;
        }
        .contact .wrap { max-width: 1260px; margin: auto; }
        .contact .section-tag { background: rgba(255,255,255,0.06); color: var(--cyan); }
        .contact .section-title { color: #fff; }
        .contact .section-desc { color: rgba(255,255,255,0.45); }
        .contact-grid { display: grid; grid-template-columns: 1fr 1.1fr; gap: 40px; align-items: start; margin-top: 40px; }
        .contact-left h3 { font-size: 1.4rem; font-weight: 700; color: #fff; margin-bottom: 8px; }
        .contact-left > p { color: rgba(255,255,255,0.45); margin-bottom: 28px; font-size: 0.95rem; }
        .ci { display: flex; align-items: center; gap: 14px; margin-bottom: 18px; }
        .ci .ci-i {
            width: 44px; height: 44px; border-radius: 12px; flex-shrink: 0;
            background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08);
            display: flex; align-items: center; justify-content: center;
        }
        .ci .ci-i i { color: var(--cyan); font-size: 0.9rem; }
        .ci .ci-l { font-size: 0.7rem; color: rgba(255,255,255,0.35); text-transform: uppercase; letter-spacing: 1.2px; }
        .ci .ci-v { font-weight: 600; color: #fff; font-size: 0.92rem; }

        .contact-form::before {
            content:''; position: absolute; top: -1px; left: 32px; right: 32px; height: 2px;
        }
        .contact-form input, .contact-form textarea {
            width: 100%; padding: 13px 16px; border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px; font-family: inherit; font-size: 0.9rem; margin-bottom: 12px;
            transition: var(--tr); background: rgba(255,255,255,0.04); color: #fff;
        }
        .contact-form input::placeholder, .contact-form textarea::placeholder {
            color: rgba(255,255,255,0.3);
        }
        .contact-form input:focus, .contact-form textarea:focus {
            outline: none; border-color: var(--blue); background: rgba(255,255,255,0.08);
            box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
        }
        .contact-form textarea { min-height: 100px; resize: vertical; }
        .btn {
            width: 100%; padding: 14px 24px; border: none; border-radius: 10px; cursor: pointer;
            font-family: inherit; font-size: 0.95rem; font-weight: 600;
            background: #fff; color: var(--c-base);
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            transition: var(--tr);
        }
        .btn:hover { background: rgba(255,255,255,0.9); transform: translateY(-1px); box-shadow: 0 6px 24px rgba(255,255,255,0.12); }

        /* === FOOTER (inside contact) === */
        .footer-content {
            color: rgba(255,255,255,0.3); text-align: center;
            margin-top: 48px; padding-top: 24px; font-size: 0.82rem;
            border-top: 1px solid rgba(255,255,255,0.06);
        }
        .footer-content .socials { margin-bottom: 10px; }
        .footer-content .socials a { color: rgba(255,255,255,0.25); margin: 0 8px; font-size: 1rem; transition: var(--tr); text-decoration: none; }
        .footer-content .socials a:hover { color: var(--cyan); }
        .footer-content p { margin: 0; }
        .footer-credit { margin-top: 6px !important; font-size: 0.75rem; color: rgba(255,255,255,0.18); }
        .footer-credit__heart { color: #e05; }
        .footer-credit a { color: rgba(255,255,255,0.3); text-decoration: none; transition: var(--tr); }
        .footer-credit a:hover { color: var(--cyan); }

        /* === RESPONSIVE === */
        @media (max-width: 768px) {
            .nav-top { display: none; }
            nav { top: 0; }
            nav .nav-links { display: none; }
            nav .nav-phone { display: none; }
            .hamburger { display: block; }
            nav .nav-links.open {
                display: flex; flex-direction: column; position: absolute; top: 100%; left: 0; width: 100%;
                background: rgba(11,29,53,0.97); backdrop-filter: blur(24px); padding: 20px 5%; gap: 4px;
                border-top: 1px solid rgba(255,255,255,0.06);
                animation: menuSlideIn 0.3s ease;
            }
            @keyframes menuSlideIn {
                from { opacity: 0; transform: translateY(-8px); }
                to { opacity: 1; transform: translateY(0); }
            }
            nav .nav-links.open li a {
                padding: 10px 14px; border-radius: 10px; font-size: 0.92rem; display: block;
            }
            nav .nav-links.open li a:hover { background: rgba(255,255,255,0.06); }
            nav .nav-links.open .mobile-phone {
                display: flex !important; align-items: center; gap: 8px;
                color: var(--cyan); font-weight: 600; font-size: 0.95rem; text-decoration: none;
                padding: 12px 14px; margin-top: 4px;
                border-top: 1px solid rgba(255,255,255,0.06);
            }
            .pitch__heading { letter-spacing: -0.025em; }
            .gallery-grid { grid-template-columns: 1fr; }
            .gallery-item.tall { aspect-ratio: 4/3; grid-row: span 1; }
            .services-bento { grid-template-columns: 1fr; }
            .srv-wide, .srv-narrow, .srv-third, .srv-medium, .srv-emergency { grid-column: span 1; min-height: 180px; }
            .contact-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

@yield('content')

<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 50,
    });

    // Typewriter on hero heading
    (function () {
        const heading = document.querySelector('.pitch__heading');
        if (!heading) { return; }

        const originalHTML = heading.innerHTML;

        // Reserve the heading's natural height so layout doesn't shift
        const reservedHeight = heading.getBoundingClientRect().height;
        heading.style.minHeight = reservedHeight + 'px';

        heading.innerHTML = '';
        heading.classList.add('tw-typing');

        // Tokenise: split into individual chars and HTML tags
        const tokens = [];
        let i = 0;
        while (i < originalHTML.length) {
            if (originalHTML[i] === '<') {
                const end = originalHTML.indexOf('>', i) + 1;
                tokens.push({ type: 'tag', value: originalHTML.slice(i, end) });
                i = end;
            } else {
                tokens.push({ type: 'char', value: originalHTML[i] });
                i++;
            }
        }

        let idx = 0;
        const stack = [heading]; // container stack for nested elements

        function step() {
            if (idx >= tokens.length) {
                heading.classList.remove('tw-typing');
                heading.style.minHeight = '';
                return;
            }

            const t = tokens[idx++];
            const parent = stack[stack.length - 1];

            if (t.type === 'char') {
                parent.appendChild(document.createTextNode(t.value));
                setTimeout(step, 58);
            } else {
                const tag = t.value;
                if (tag.startsWith('</')) {
                    // Closing tag — pop container
                    if (stack.length > 1) { stack.pop(); }
                } else if (/^<br/i.test(tag)) {
                    parent.appendChild(document.createElement('br'));
                } else {
                    // Opening tag — create element, push to stack
                    const m = tag.match(/^<([\w-]+)([\s\S]*?)\/?>$/);
                    if (m) {
                        const el = document.createElement(m[1]);
                        const attrRe = /([\w-]+)="([^"]*)"/g;
                        let a;
                        while ((a = attrRe.exec(m[2])) !== null) {
                            el.setAttribute(a[1], a[2]);
                        }
                        parent.appendChild(el);
                        if (!tag.endsWith('/>')) { stack.push(el); }
                    }
                }
                step(); // no delay for structural tags
            }
        }

        // Start after entrance animation begins
        setTimeout(step, 650);
    }());

    // Nav scroll behavior — hide top bar & compress main nav on scroll
    const navTop = document.getElementById('navTop');
    const mainNav = document.getElementById('mainNav');
    let lastScroll = 0;
    window.addEventListener('scroll', () => {
        const y = window.scrollY;
        if (y > 60) {
            navTop.classList.add('hidden');
            mainNav.classList.add('scrolled');
        } else {
            navTop.classList.remove('hidden');
            mainNav.classList.remove('scrolled');
        }
        lastScroll = y;
    }, { passive: true });
</script>
</body>
</html>
