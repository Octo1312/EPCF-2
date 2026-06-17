import './styles/app.scss';

// ===== SCRIPT DU CARROUSEL =====
// On attend que le DOM soit entièrement chargé avant d'exécuter le script
document.addEventListener('DOMContentLoaded', () => {
    // Récupère le conteneur qui contient toutes les slides (la "piste" qui glisse)
    const track = document.getElementById('carouselTrack');
    if (!track) return; // Si l'élément n'existe pas, on arrête tout (sécurité)

    // Récupère le parent visible du carrousel (la "fenêtre" qui cache le reste)
    const viewport = track.closest('.carousel-viewport');
    if (!viewport) return;

    // Récupère toutes les slides individuelles à l'intérieur de la piste
    const slides = track.querySelectorAll('.carousel-slide');
    if (slides.length === 0) return; // Pas de slides = on arrête

    let index = 0; // Index de la slide actuellement affichée

    // Fonction qui déplace le carrousel vers la slide n°i
    function goTo(i) {
        // Gestion du "bouclage" : si on dépasse les bornes, on revient au début/à la fin
        if (i < 0) {
            index = slides.length - 1; // Si on recule avant la 1ère, on va à la dernière
        } else if (i >= slides.length) {
            index = 0; // Si on avance après la dernière, on revient à la 1ère
        } else {
            index = i;
        }

        // Largeur de la fenêtre visible (utilisée pour calculer le décalage du translateX)
        const slideWidth = viewport.clientWidth;
        // Largeur totale de l'écran (utilisée pour le calcul d'échelle responsive)
        const viewportWidth = window.innerWidth;
        let safetyInset = 0; // Marge de sécurité pour éviter que la carte dépasse sur petit écran

        // Sur très petits écrans, on réduit un peu la largeur "utile" de la carte
        if (viewportWidth <= 360) {
            safetyInset = 8;
        } else if (viewportWidth <= 390) {
            safetyInset = 12;
        } else if (viewportWidth <= 425) {
            safetyInset = 18;
        }

        // Calcule un ratio d'échelle basé sur une largeur de référence de 350px
        const rawScale = (slideWidth - safetyInset) / 350;
        // Sur mobile (<= 425px), on adapte l'échelle entre 0.68 et 1 ; sur desktop, échelle fixe à 1
        const cardScale = viewportWidth <= 425 ? Math.max(0.68, Math.min(1, rawScale)) : 1;

        // Applique l'échelle calculée via une variable CSS (--card-scale), utilisée dans le SCSS
        track.style.setProperty('--card-scale', cardScale.toString());
        // Déplace la piste horizontalement pour afficher la bonne slide
        track.style.transform = `translateX(-${index * slideWidth}px)`;
    }

    // Quand la fenêtre est redimensionnée, on recalcule la position/l'échelle
    // (sans changer de slide, juste pour que ça reste bien aligné)
    window.addEventListener('resize', () => goTo(index));

    // Défilement automatique : passe à la slide suivante toutes les 5 secondes
    let autoplay = setInterval(() => {
        goTo(index + 1);
    }, 5000);

    // Boutons de navigation manuelle (précédent / suivant)
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            clearInterval(autoplay); // Stoppe l'autoplay dès qu'on clique manuellement
            goTo(index - 1);
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            clearInterval(autoplay); // Pareil ici
            goTo(index + 1);
        });
    }

    goTo(0); // Initialise le carrousel sur la première slide au chargement
});

// ===== MENU BURGER (menu mobile) =====
const burgerBtn = document.getElementById('burgerBtn'); // Le bouton "hamburger"
const navMenu   = document.getElementById('navMenu');   // Le menu de navigation à afficher/cacher

if (burgerBtn && navMenu) {
    // Au clic sur le bouton burger : on ouvre/ferme le menu
    burgerBtn.addEventListener('click', () => {
        const isOpen = navMenu.classList.toggle('is-open'); // Bascule la classe "is-open" et récupère le nouvel état
        burgerBtn.classList.toggle('is-open', isOpen); // Synchronise l'apparence du bouton (ex: icône qui change)
        burgerBtn.setAttribute('aria-expanded', isOpen); // Mise à jour pour l'accessibilité (lecteurs d'écran)
    });

    // Si on clique n'importe où ailleurs sur la page (hors menu et hors bouton), on referme le menu
    document.addEventListener('click', (e) => {
        if (!burgerBtn.contains(e.target) && !navMenu.contains(e.target)) {
            navMenu.classList.remove('is-open');
            burgerBtn.classList.remove('is-open');
            burgerBtn.setAttribute('aria-expanded', false);
        }
    });
}