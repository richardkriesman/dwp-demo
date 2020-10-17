/**
 * Automatically resizes textarea elements.
 */
(() => {
    const textAreas = document.getElementsByTagName('textarea');
    for (let i = 0; i < textAreas.length; i++) {
        textAreas[i].setAttribute('style', 'height:' + textAreas[i].scrollHeight + 'px;overflow-y:hidden;');
        textAreas[i].addEventListener('input', function() {
           this.style.height = 'auto';
           this.style.height = this.scrollHeight + 'px';
        }, false);
    }
})();