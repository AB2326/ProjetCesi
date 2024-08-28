import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

document.addEventListener('DOMContentLoaded', function () {
    let accessibilityEnabled = false;
    const accessibilityButton = document.querySelector('.accessibility-trigger');
    accessibilityButton.addEventListener('click', function () {
        accessibilityEnabled = !accessibilityEnabled;

        document.body.classList.toggle('blue-background', accessibilityEnabled);

        const elementsToToggleYellow = document.querySelectorAll('.mb-3, .article, .article .entete h2, .navbar-brand-text, .article-content, .article-title, .fa-bold , .fa-italic , .fa-list-ul,.fa-list-ol,.fa-underline');
        elementsToToggleYellow.forEach(function (element) {
            element.classList.toggle('yellow-text', accessibilityEnabled);
        });

        const articles = document.querySelectorAll('.article, .article-container, .comment, .comment-container, .comment-form-container, .editor-toolbar');
        articles.forEach(function (article) {
            article.classList.toggle('blue-background', accessibilityEnabled);
        });
    });
});